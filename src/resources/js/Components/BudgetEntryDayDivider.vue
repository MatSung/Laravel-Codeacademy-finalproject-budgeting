<script setup>

</script>

<template>
    <tr>
        <td class="p-2"></td>
    </tr>
    <tr class="border-b-2">
        <td class="px-2 py-2 text-white text-left bg-slate-800 font-bold rounded-t-lg">
            <slot name="date">
                Date
            </slot>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <slot name="items">

    </slot>
</template>