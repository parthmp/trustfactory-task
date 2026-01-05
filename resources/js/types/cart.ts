// types/cart.ts
export interface CartProduct {
  id: number | string;
  product_name: string;
  price: number | string;
  // Add other product properties as needed
  slug?: string;
  image?: string;
  description?: string;
  stock_quantity?: number;
}

export interface CartItem {
  id: number | string;
  user_id: number | string;
  product_id: number | string;
  quantity: number;
  created_at?: string;
  updated_at?: string;
  product: CartProduct;
  line_total: number | string; // Assuming this is added via accessor
}

export interface CartSummary {
  grand_total: number | string;
  grand_total_formatted?: string;
  total_items: number;
  total_quantity: number;
}

export interface CartResponse {
  items: CartItem[];
  summary: CartSummary;
}