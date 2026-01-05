<script setup lang="ts">

import CartAppLayout from '@/layouts/app/CartAppLayout.vue';
import Card from '@/components/ui/card/Card.vue';
import Button from '@/components/ui/button/Button.vue';
import { router, Link } from '@inertiajs/vue3';
import type { CartResponse } from '@/types/cart';

import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableFooter,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';

interface Props {
  canRegister?: boolean;
  currencySymbol: string;
  cartItemsNumber: number;
  cartItems: CartResponse;
  error?: string;
}

withDefaults(
    defineProps<Props>(),
    {
		canRegister: true,
        cartItemsNumber: 0,
    },
);

const modifyCart = (productId: number, operation: string) : void => {
	router.post('/cart/modify', {
		productId: productId,
		quantity: 1,
		operation: operation
	})
}

const checkout = () : void => {
	router.get('/cart/checkout');
}


</script>

<template>
   
	<CartAppLayout :canRegister="canRegister" :cartItemsNumber="cartItemsNumber">
		<section>
			<Link href="/" class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
            >
            	Home
            </Link>
			
			<Card class="p-8 mt-5">
				<h1 class="text-xl flex items-center gap-10">
					<span>Cart ({{ cartItemsNumber }})</span>
					<span v-if="cartItems.items.length > 0"><Button @click="checkout" class="cursor-pointer">Checkout</Button></span>
				</h1>
				
				<Table>
					<TableCaption>
						<p v-if="cartItems.items.length === 0">No items in cart</p>
						<p v-else>A list of cart products.</p>
						</TableCaption>
					<TableHeader>
					<TableRow>
						<TableHead class="w-[100px]">
						Product
						</TableHead>
						<TableHead>Quantity</TableHead>
						<TableHead>Line total</TableHead>
						<TableHead class="text-right">
						-
						</TableHead>
					</TableRow>
					</TableHeader>
					<TableBody>
						<TableRow v-for="item in cartItems.items" :key="item.id">
							<TableCell class="font-medium">
							{{item.product.product_name}}
							</TableCell>
							<TableCell>{{item.quantity}}</TableCell>
							<TableCell>{{currencySymbol}} {{ item.line_total }}</TableCell>
							<TableCell class="text-right">
								<div class="flex gap-4">
									<Button class="cursor-pointer" @click="() => modifyCart(item.product.id, 'add')">+</Button>
									<Button class="cursor-pointer" @click="() => modifyCart(item.product.id, 'sub')">-</Button>
								</div>
							</TableCell>
						</TableRow>
					
					</TableBody>
					<p></p>
				</Table>
				<p>Totals</p>
				<p>Quantity: {{ cartItems.summary.total_quantity }}</p>
				<p>Grand total: {{currencySymbol}} {{ cartItems.summary.grand_total }}</p>
				
			</Card>
		</section>
	</CartAppLayout>

</template>
