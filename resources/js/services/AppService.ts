import { http } from '@/lib/http';



export interface CardDetail {
  id: number;
  gol_1: number | null;
  gol_2: number | null;
}

export async function saveCardDetailResult(payload:CardDetail) {
  const { data } = await http.post('/card_details/save_card_detail_result', payload);
  return data;  
}



