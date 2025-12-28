 <div class="max-w-full mx-auto px-0 lg:px-8">
     <div class="relative flex items-center justify-between h-24">
         <div class="absolute inset-y-0 left-0 flex items-center justify-between w-full">
             <div class="flex-shrink-0 flex items-center hover:cursor-pointer">
                 @component('components.general.pestlogo', ['style' => 'lg:h-10 w-auto h-8'])
                 @endcomponent
             </div>
             <div class="hidden sm:block sm:ml-6">
                 <div class="flex">
                     <a href="/" class="text-black border-r hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                         aria-current="">
                         Find a Pest Controller
                     </a>

                     <a href="/about" class="text-black border-r hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                         aria-current="">
                         About Us
                     </a>

                     <a href="/pests" class="text-black border-r hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                         aria-current="">
                         A-Z of Pests
                     </a>

                     <a href="/blog" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                         aria-current="">
                         Blog
                     </a>

                 </div>
             </div>
         </div>
         <template x-if="true" x-data="{ open: false }">
             <div class="w-full">
                 <div
                     class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:hidden">
                     <div>
                         <svg x-show="!open" @click="open = ! open" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                             <path fill-rule="evenodd"
                                 d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z"
                                 clip-rule="evenodd" />
                         </svg>

                         <svg x-show="open" @click="open = ! open" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-gray-5 fill-current">
                             <path
                                 d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                         </svg>
                     </div>

                 </div>

                 <div x-show="open" class="bg-white w-full pt-60 shadow-lg" @click.outside="open = false">
                     <div class="p-4 space-y-4">
                         <div>
                             <a href="/" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                                 aria-current="">
                                 Find a Pest Controller
                             </a>
                         </div>

                         <div>
                             <a href="/about" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                                 aria-current="">
                                 About Us
                             </a>
                         </div>

                         <div>
                             <a href="/pests" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                                 aria-current="">
                                 A-Z of Pests
                             </a>
                         </div>

                         <div>
                             <a href="/blog" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 text-sm"
                                 aria-current="">
                                 Blog
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
         </template>
     </div>
 </div>
