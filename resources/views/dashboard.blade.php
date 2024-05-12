<x-app-layout>
    <div class="flex justify-center items-center h-full">
        <div class="w-full max-w-3xl">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-gray-100 overflow-hidden shadow-xl sm:rounded-lg p-8">
                        <h1 class="text-3xl font-bold mb-4 text-center">Bienvenidos a Panelly</h1>
                        <div class="flex justify-center">
                            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                                <livewire:total-users />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
