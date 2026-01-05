<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

import { ProductType } from '@/types/product';
import { usePage } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import { toast } from 'vue-sonner';


const props = withDefaults(
    defineProps<{
        canRegister: boolean;
		products : Array<ProductType>
		cartItemsNumber : number
    }>(),
    {
        canRegister: true,
        cartItemsNumber: 0,
    },
);

const page = usePage();

// Function to show toast based on flash messages
const showFlashToast = (flash: any) => {
    if (flash?.success) {
        toast.success(flash.success)
    }

    if (flash?.error) {
        toast.error(flash.error)
    }
}

// Check for flash messages on mount
onMounted(() => {
    showFlashToast(page.props.flash);
});

// Watch for changes in flash messages
watch(
    () => page.props.flash,
    (flash: any) => {
        console.log('flash changed', flash);
        showFlashToast(flash);
    },
    { deep: true, immediate: true }
)

</script>

<template>
	<Toaster position="top-center" rich-colors class="z-20" />

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
   
	<main class="container mx-auto pl-5 pr-5">
		 <header class="w-full mt-5 text-sm not-has-[nav]:hidden">
            <nav class="flex items-center justify-end gap-4">
				<Link
					v-if="$page.props.auth.user"
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
			<slot :props="page.props"></slot>
		</section>

			
			
	</main>
</template>
