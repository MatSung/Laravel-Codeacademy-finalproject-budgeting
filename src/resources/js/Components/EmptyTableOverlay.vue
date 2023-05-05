<script setup>

</script>

<template>
    <div class="relative">
        <div>
            <table class="border-collapse table-fixed w-full text-md mb-4 blur-sm select-none">
                <thead>
                    <tr>
                        <th class=" font-bold pl-2 pt-2 pb-3 text-white text-left bg-slate-800 lg:w-44 sm:w-28">
                            Date/Time
                            <button type="button">📆</button>
                            <button type="button">⏰</button>
                        </th>
                        <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-28">Inc/Exp</th>
                        <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-44">Category</th>
                        <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-44">Subcategory</th>
                        <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-32">Amount</th>
                        <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Note</th>
                        <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-20">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 bg-income">
                        <td class="p-2">2023-01-23 12:30:12</td>
                        <td>Income</td>
                        <td>Salary</td>
                        <td></td>
                        <td class="pl-3">12</td>
                        <td>Job pay</td>
                        <td>
                            <div class="flex gap-4 justify-end pr-4">
                                <button class="w-4 inline-block">✏</button>
                                <button class="w-4 inline-block">✖</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b-2 bg-expense">
                        <td class="p-2">2023-01-23 12:30:12</td>
                        <td>Expense</td>
                        <td>Food</td>
                        <td>Groceries</td>
                        <td class="pl-3">12</td>
                        <td></td>
                        <td>
                            <div class="flex gap-4 justify-end pr-4">
                                <button class="w-4 inline-block">✏</button>
                                <button class="w-4 inline-block">✖</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b-2 bg-income">
                        <td class="p-2">2023-01-23 12:30:12</td>
                        <td>Income</td>
                        <td>Salary</td>
                        <td>Freelance Clowning</td>
                        <td class="pl-3">12</td>
                        <td></td>
                        <td>
                            <div class="flex gap-4 justify-end pr-4">
                                <button class="w-4 inline-block">✏</button>
                                <button class="w-4 inline-block">✖</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="relative text-center text-black font-bold py-2 -top-28">
            <slot>
                Your database of entries is empty, go to the entries page to add new entries.
            </slot>
        </div>
    </div>
</template>