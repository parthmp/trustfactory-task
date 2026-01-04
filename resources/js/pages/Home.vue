<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import Product from '@/components/Product.vue';

import { ProductType } from '@/types/product';

withDefaults(
    defineProps<{
        canRegister: boolean;
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
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
   
	<main class="container mx-auto pl-5 pr-5">
		 <header class="w-full mt-5 text-sm not-has-[nav]:hidden">
            <nav class="flex items-center justify-end gap-4">
				<Link
					href="/cart"
					class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
				>
					Cart ({{cartItemsNumber}})
				</Link>
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
					
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>

		<section>
			<p v-if="error !== ''" class="text-red-500">{{ error }}</p>
			<div class="grid grid-cols-12 gap-5 mt-10">
				<div v-for="(product, index) in products" class="col-span-12 mb-5 sm:col-span-6 md:col-span-4 lg:col-span-3">
					<Product :data="product" :currencySymbol="currencySymbol" :key="index"></Product>
				</div>
			</div>
		</section>

			
			
	</main>
</template>
