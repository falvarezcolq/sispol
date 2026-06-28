<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Fixture;
use App\Models\Group;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;


class FixtureController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $group_id = (int) $request->input('group_id', 0);
        $perPage = (int) $request->input('per_page', 10);

        $fixtures = Fixture::with(['team1', 'team2', 'group'])
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('team1', function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%");
                })->orWhereHas('team2', function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%");
                });
            })
            ->when($group_id > 0, function ($query) use ($group_id) {
                $query->where('group_id', $group_id);
            })
            ->orderBy('match_date')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Fixtures/Index', [
            'fixtures' => $fixtures,
            'groups' => Group::orderBy('name')->get(),
            'search' => $search !== '' ? $search : null,
            'group_id' => $group_id > 0 ? $group_id : null,
        ]);
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();

        return Inertia::render('Fixtures/Create', [
            'countries' => $countries,
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id_1' => 'required|integer|exists:countries,id|different:country_id_2',
            'country_id_2' => 'required|integer|exists:countries,id|different:country_id_1',
            'group_id' => 'required|integer|exists:groups,id',
            'match_date' => 'required|date_format:Y-m-d H:i',
        ]);


        DB::transaction(function () use ($request) {
            $fixture = Fixture::create([
                'country_id_1' => $request->country_id_1,
                'country_id_2' => $request->country_id_2,
                'group_id' => $request->group_id,
                'match_date' => $request->match_date,
                'created_by' => auth()->id(),
            ]);

            // Add to cards
            $cards = Card::get();
            foreach ($cards as $card) {
                $card->cardDetails()->create([
                    'fixture_id' => $fixture->id,
                    'created_by' => auth()->id(),
                ]);
            }
        });
     


        return redirect()->route('fixtures.index')->with('success', 'Partido creado exitosamente.');
    }

    public function show(Fixture $fixture)
    {
        $fixture->load(['team1', 'team2', 'group']);

        return Inertia::render('Fixtures/Show', [
            'fixture' => $fixture,
        ]);
    }

    public function edit(Fixture $fixture)
    {
        $fixture->load(['team1', 'team2', 'group']);
        $countries = Country::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();

        return Inertia::render('Fixtures/Edit', [
            'fixture' => $fixture,
            'countries' => $countries,
            'groups' => $groups,
        ]);
    }

    public function update(Request $request, Fixture $fixture)
    {
        $request->validate([
            'country_id_1' => 'required|integer|exists:countries,id|different:country_id_2',
            'country_id_2' => 'required|integer|exists:countries,id|different:country_id_1',
            'group_id' => 'required|integer|exists:groups,id',
            'match_date' => 'required|date_format:Y-m-d H:i',
            'gol_1' => 'nullable|integer|min:0',
            'gol_2' => 'nullable|integer|min:0',
            'played' => 'boolean',
            'penalties' => 'boolean',
            'penalties_gol_1' => 'nullable|integer|min:0',
            'penalties_gol_2' => 'nullable|integer|min:0',
        ]);

        $fixture->update([
            'country_id_1' => $request->country_id_1,
            'country_id_2' => $request->country_id_2,
            'group_id' => $request->group_id,
            'match_date' => $request->match_date,
            'gol_1' => $request->gol_1,
            'gol_2' => $request->gol_2,
            'played' => $request->boolean('played'),
            'penalties' => $request->boolean('penalties'),
            'penalties_gol_1' => $request->penalties_gol_1,
            'penalties_gol_2' => $request->penalties_gol_2,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('fixtures.index')->with('success', 'Partido actualizado exitosamente.');
    }

    public function destroy(Fixture $fixture)
    {
        $fixture->update(['deleted_by' => auth()->id()]);
        $fixture->delete();

        return redirect()->route('fixtures.index')->with('success', 'Partido eliminado exitosamente.');
    }
}
