<script setup></script>

<template>
    <div class="w-full pb-10 overflow-x-auto">
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px] text-lg xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-main_bg text-white"
                >
                    <slot name="head"></slot>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <slot name="body"></slot>
                </tr>
            </tbody>
        </table>
    </div>
</template>
