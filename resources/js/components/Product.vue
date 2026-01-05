<script lang="ts" setup>

	import { router, usePage } from '@inertiajs/vue3';
	import Button from './ui/button/Button.vue';
	import { ProductType } from '@/types/product';

	const props = defineProps<{data : ProductType, currencySymbol: string}>();

	const addToCart = () => {
		router.post('/cart/modify', {
			productId: props.data.id,
			quantity: 1,
			operation: 'add'
		})
	}

</script>

<template>
	<div class="">
		<img :src="data.image_url+'?id='+Math.random()" alt="product-image" class="w-full rounded-xl pb-4">
		<p class="text-xl text-center">{{ data.product_name }}</p>
		<p class="text-center">{{ currencySymbol }} {{ data.price }}</p>
		<p v-if="data.stock_quantity > 0" class="text-center">In stock</p>
		<p v-else class="text-center">Out of stock</p>
		<div class="flex justify-center mt-2">
			<Button :disabled="data.stock_quantity < 1" @click="addToCart" class="cursor-pointer">Add to cart</Button>
		</div>
	</div>
</template>