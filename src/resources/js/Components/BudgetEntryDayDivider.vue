<script setup>

</script>

<template>
    <tr class="border-b-2">
        <td class="px-2 pt-5">
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