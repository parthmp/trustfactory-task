<script setup lang="ts">

import Product from '@/components/Product.vue';

import { ProductType } from '@/types/product';
import CartAppLayout from '@/layouts/app/CartAppLayout.vue';

withDefaults(
    defineProps<{
		canRegister?: boolean,
		error:string,
		currencySymbol:string,
		products : Array<ProductType>
		cartItemsNumber : number
    }>(),
    {
		canRegister: true,
        cartItemsNumber: 0,
    },
);

</script>

<template>
   
	<CartAppLayout :canRegister="canRegister" :cartItemsNumber="cartItemsNumber">
		<section>
			<p v-if="error !== ''" class="text-red-500">{{ error }}</p>
			<div class="grid grid-cols-12 gap-5 mt-10">
				<div v-for="(product, index) in products" class="col-span-12 mb-5 sm:col-span-6 md:col-span-4 lg:col-span-3" :key="product.id">
					<Product :data="product" :currencySymbol="currencySymbol"></Product>
				</div>
			</div>
		</section>
	</CartAppLayout>

</template>
