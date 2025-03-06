
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let count = 1; 

        document.getElementById('add-more').addEventListener('click', function() {
            const container = document.getElementById('documentation-fields');
            
            const newField = document.createElement('div');
            newField.classList.add('grid', 'grid-cols-1', 'gap-4', 'md:grid-cols-3');
            newField.innerHTML = `
                <div>
                    <label class="text-sm font-medium text-gray-500">Items</label>
                    <input type="text" name="documents[${count}][title]" class="block w-full p-2 mt-1 border border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Validity / Expiry Date</label>
                    <input type="text" name="documents[${count}][description]" class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Location</label>
                    <input type="text" name="documents[${count}][location]" class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
                </div>
            `;
            
            container.appendChild(newField);
            count++;
        });
    });
</script>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Site Visit Details') }}
            </h2>
            <a href="{{ route('site-visits-info.index') }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Visit to {{ $siteVisit->property->name }}</h3>
                    <div>
                        <a href="{{ route('site-visits-info.edit', $siteVisit->id) }}"
                            class="inline-flex items-center px-4 py-2 mr-2 text-xs font-semibold tracking-widest text-white uppercase bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                            Approve
                        </a>
                        <a href="{{ route('site-visits-info.edit', $siteVisit->id) }}"
                            class="inline-flex items-center px-4 py-2 mr-2 text-xs font-semibold tracking-widest text-white uppercase bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                            Revoke
                        </a>
                        <form action="{{ route('site-visits-info.destroy', $siteVisit->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-red-600 border border-transparent rounded-md hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to delete this site visit?')">
                                Reject
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Approval Stage -->
                <div class="p-4 mt-6 mb-6 rounded-lg bg-gray-50">
                    <div class="flex">
                        <div class="w-full">
                            <div class="relative mb-2">
                                <div
                                    class="flex items-center justify-center w-10 h-10 mx-auto text-lg bg-white border-2 border-gray-200 rounded-full">
                                    <span class="flex items-center justify-center w-full h-full text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-5" viewBox="0 0 32 32">
                                            <path fill="currentColor"
                                                d="M2.079 3.975c-.417-1.267.902-2.407 2.095-1.81L29.168 14.66c.902.45 1.068 1.583.5 2.285q-.366-.345-.768-.646a.5.5 0 0 0-.179-.745L3.727 3.059a.5.5 0 0 0-.698.603l3.898 11.84H18.5a.5.5 0 0 1 .429.243a9 9 0 0 0-1.09.757H6.928L3.03 28.342a.5.5 0 0 0 .698.604L14.5 23.56q.003.55.071 1.082L4.174 29.84c-1.193.597-2.512-.544-2.095-1.81l3.96-12.028zM23.499 31a7.5 7.5 0 1 0 0-15a7.5 7.5 0 0 0 0 15m-.25-12.5a.75.75 0 0 1 .75.75V23h2.75a.75.75 0 0 1 0 1.5h-3.5a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 1 .75-.75" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="text-xs text-center md:text-base">Prepared</div>
                                <div class="mt-2 text-xs text-gray-500">NURUL SHAHIDAH BINTI RAS TAMAJIS</div>
                            </div>
                        </div>


                        <div class="w-full">
                            <div class="relative mb-2">
                                <div class="absolute flex items-center content-center align-middle align-center"
                                    style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="items-center flex-1 w-full align-middle bg-gray-200 rounded align-center status-indicator"
                                        data-indicator-type="Pending">
                                        <div class="w-0 py-1 bg-purple-300 rounded" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center w-10 h-10 mx-auto text-lg text-white bg-white border-2 border-gray-200 rounded-full">
                                    <span class="w-full text-center text-gray-600">
                                        <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" width="24" height="24">
                                            <path class="heroicon-ui"
                                                d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="text-xs text-center md:text-base">Legal Review</div>
                                <div class="mt-2 text-xs text-gray-500">ZULHIDA BINTI ABD MAURAD</div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="relative mb-2">
                                <div class="absolute flex items-center content-center align-middle align-center"
                                    style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="items-center flex-1 w-full align-middle bg-gray-200 rounded align-center status-indicator"
                                        data-indicator-type="Admin-approval">
                                        <div class="w-0 py-1 bg-purple-300 rounded" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center w-10 h-10 mx-auto text-lg text-white bg-white border-2 border-gray-200 rounded-full">
                                    <span class="w-full text-center text-gray-600">
                                        <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" width="24" height="24">
                                            <path class="heroicon-ui"
                                                d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="text-xs text-center md:text-base">Admin Verified</div>
                                <div class="mt-2 text-xs text-gray-500">{{ Auth::user()->name }}</div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="relative mb-2">
                                <div class="absolute flex items-center content-center"
                                    style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="items-center flex-1 w-full bg-gray-200 rounded status-indicator"
                                        data-indicator-type="Collect-Vehicle">
                                        <div class="w-0 py-1 bg-purple-300 rounded" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-center w-10 h-10 mx-auto text-lg bg-white border-2 border-gray-200 rounded-full">
                                    <span class="flex items-center justify-center w-full h-full text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-5" stroke-width="1"
                                            stroke="currentColor" viewBox="0 0 32 32">
                                            <g fill="currentColor">
                                                <path
                                                    d="M14.683 14.698a.5.5 0 0 0 .33-.124L26.33 4.652l-.66-.752l-11.317 9.921a.5.5 0 0 0 .33.877" />
                                                <path
                                                    d="M10.188 32C16.33 32 20 27.17 20 22.5c0-1.346-.322-2.829-.798-3.792l4.522-2.261A.5.5 0 0 0 24 16v-4h3l.113-.006c.666-.045.865-.257.887-.994V7h3c.129 0 .218.014.278.023c.121.019.347.054.543-.122c.202-.18.193-.408.185-.609C32.004 6.22 32 6.125 32 6V1.469A1.47 1.47 0 0 0 30.531 0h-3.875a1.48 1.48 0 0 0-.969.364L12.5 11.924c-.649-.13-1.63-.299-2.313-.299C4.57 11.625 0 16.195 0 21.812S4.57 32 10.188 32m0-19.375c.501 0 1.359.12 2.354.328a.495.495 0 0 0 .432-.113L26.345 1.118A.474.474 0 0 1 26.656 1h3.875c.259 0 .469.21.469.469V6h-3.5a.5.5 0 0 0-.5.5V11h-3.5a.5.5 0 0 0-.5.5v4.191l-4.724 2.362a.5.5 0 0 0-.182.74c.44.607.906 2.114.906 3.707c0 4.178-3.296 8.5-8.812 8.5C5.122 31 1 26.878 1 21.812s4.122-9.187 9.188-9.187" />
                                                <path
                                                    d="M8.5 27c1.93 0 3.5-1.57 3.5-3.5S10.43 20 8.5 20S5 21.57 5 23.5S6.57 27 8.5 27m0-6c1.378 0 2.5 1.122 2.5 2.5S9.878 26 8.5 26S6 24.878 6 23.5S7.122 21 8.5 21" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs md:text-base">Site Visit Ongoing</div>
                                <div class="mt-2 text-xs text-gray-500">NURUL SHAHIDAH BINTI RAS TAMAJIS    </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="relative mb-2">
                                <div class="absolute flex items-center content-center align-middle align-center"
                                    style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="items-center flex-1 w-full align-middle bg-gray-200 rounded align-center status-indicator"
                                        data-indicator-type="Return-Vehicle">
                                        <div class="w-0 py-1 bg-purple-300 rounded" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-center w-10 h-10 mx-auto text-lg bg-white border-2 border-gray-200 rounded-full">
                                    <span class="flex items-center justify-center w-full h-full text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-5" stroke-width="1"
                                            stroke="currentColor" viewBox="0 0 48 48">
                                            <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="4">
                                                <path d="m13 8l-7 6l7 7" />
                                                <path
                                                    d="M6 14h22.994c6.883 0 12.728 5.62 12.996 12.5c.284 7.27-5.723 13.5-12.996 13.5H11.998" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="text-xs text-center md:text-base">Site Visit Completed</div>
                                <div class="mt-2 text-xs text-gray-500">ZULHIDA BINTI ABD MAURAD</div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="relative mb-2">
                                <div class="absolute flex items-center content-center align-middle align-center"
                                    style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="items-center flex-1 w-full align-middle bg-gray-200 rounded align-center status-indicator"
                                        data-indicator-type="Completed">
                                        <div class="w-0 py-1 bg-purple-300 rounded" style="width: 0%;"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center w-10 h-10 mx-auto text-lg text-white bg-white border-2 border-gray-200 rounded-full">
                                    <span class="w-full text-center text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-center md:text-base">Report</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 mb-6 rounded-lg bg-gray-50">
                    <h4 class="mb-2 font-medium text-gray-700 text-md">Visit Information</h4>
                    <dl class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $siteVisit->date_visit->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $siteVisit->formatted_time }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $siteVisit->status_badge_class }}">
                                    {{ ucfirst($siteVisit->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Inspector</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $siteVisit->inspector_name ?? 'Not assigned' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $siteVisit->created_at->format('M d, Y H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $siteVisit->updated_at->format('M d, Y H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                @if ($siteVisit->notes)
                    <div class="p-4 mb-6 rounded-lg bg-gray-50">
                        <h4 class="mb-2 font-medium text-gray-700 text-md">Notes</h4>
                        <div class="p-4 mt-1 text-sm text-gray-900 bg-white border border-gray-200 rounded">
                            {!! nl2br(e($siteVisit->notes)) !!}
                        </div>
                    </div>
                @endif

                @if ($siteVisit->attachment)
                    <div class="p-4 mb-6 rounded-lg bg-gray-50">
                        <h4 class="mb-2 font-medium text-gray-700 text-md">Attachment</h4>
                        <div class="flex items-center mt-1">
                            <a href="{{ $siteVisit->attachment_url }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                View Attachment
                            </a>
                        </div>
                    </div>
                @endif

                <form method="POST" class="p-4 mt-6 rounded-lg bg-gray-50">
                    @csrf
                    <h4 class="mb-2 font-medium text-gray-700 text-md">Legal Documentation</h4>
                    
                    <div id="documentation-fields" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Items</label>
                                <input type="text" name="documents[0][title]" class="block w-full p-2 mt-1 border border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Validity / Expiry Date</label>
                                <input type="text" name="documents[0][description]" class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Location</label>
                                <input type="text" name="documents[0][location]" class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                
                    <button type="button" id="add-more" class="px-4 py-2 mt-4 text-white bg-yellow-600 rounded-md">Add More</button>
                    <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-600 rounded-md">Save</button>
                </form>

                @if ($siteVisit->status === 'completed')
                    <div class="p-4 mt-6 rounded-lg bg-gray-50">
                        <h4 class="mb-2 font-medium text-gray-700 text-md">Site Visit Checklist</h4>
                        <div class="p-4 mt-1 bg-white border border-gray-200 rounded">
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Property exterior inspection
                                        completed</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Property interior inspection
                                        completed</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Structural assessment</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Maintenance issues identified and
                                        documented</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Safety inspection completed</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 text-sm text-gray-700">Photos taken for documentation</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
