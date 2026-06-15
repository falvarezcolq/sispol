<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Fixture;
use App\Models\CardDetail;
use Illuminate\Support\Facades\DB;  

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 10);
        $user_id = (int) $request->input('user_id', 0);

        $cards = Card::query()
            ->with('user:id,name')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('card_number', 'ilike', "%{$search}%")
                        ->orWhere('card_type', 'ilike', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'ilike', "%{$search}%");
                        });
                });
            })
            ->when($user_id > 0, function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Cards/Index', [
            'cards' => $cards,
            'search' => $search !== '' ? $search : null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = (int) $request->input('user_id', 0);
        return Inertia::render('Cards/Create', [
            'users' => User::query()
                ->orderBy('name')
                ->get(['id', 'name']),
            'user_id' => $user_id > 0 ? $user_id : null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'balance' => 'required|numeric|min:0',
                'card_type' => 'required|string|max:255',
            ]);
            DB::transaction(function() use ($request, $validated){
                $card = Card::create([
                    ...$validated,
                    'card_number' => Card::generateCardNumber(),
                    'created_by' => auth()->id(),
                ]);
                $fixtures = Fixture::get();
                foreach ($fixtures as $fixture) {
                    CardDetail::create([
                        'card_id' => $card->id,
                        'fixture_id' => $fixture->id,
                        'created_by' => auth()->id(),
                    ]);
                }
            });
            return redirect()->route('cards.index')->with('success', 'Tarjeta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return redirect()->route('cards.edit', $card);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        return Inertia::render('Cards/Edit', [
            'card' => $card,
            'users' => User::query()
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'card_number' => 'required|integer|min:1',
            'balance' => 'required|numeric|min:0',
            'card_type' => 'required|string|max:255',
        ]);

        $card->update([
            ...$validated,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('cards.index')->with('success', 'Tarjeta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->update(['deleted_by' => auth()->id()]);
        $card->delete();

        return redirect()->route('cards.index')->with('success', 'Tarjeta eliminada exitosamente.');
    }


    public function saveCardDetailResult(Request $request)
    {

        $user = auth()->user();

        $validated = $request->validate([
            'id' => 'required|exists:card_details,id',
            'gol_1' => 'required|integer|min:0',
            'gol_2' => 'required|integer|min:0',
        ]);

        $cardDetail = CardDetail::findOrFail($validated['id']);

        $card = $cardDetail->card()->first();

        if ($card->user_id !== $user->id) {
            if (! $user->is_admin) {    
                return response()->json(['message' => 'No autorizado.'], 403);
            }
        }

        if( $cardDetail->fixture->played) {
            return response()->json(['message' => 'No se pueden modificar resultados de partidos ya jugados.'], 400);
        }

        $time = new \DateTime();
        $match_time = new \DateTime($cardDetail->fixture->match_date);
        
        if($time > $match_time) {
            return response()->json(['message' => 'No se pueden modificar resultados de partidos que estan siendo jugados.'], 400);
        }
      

        $cardDetail->update([
            'gol_1' => $validated['gol_1'],
            'gol_2' => $validated['gol_2'],
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Resultado guardado exitosamente.']);
    }
}
