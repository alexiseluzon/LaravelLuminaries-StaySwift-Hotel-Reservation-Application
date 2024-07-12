<template>
    <Head title="Borrowed Items" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <font-awesome-icon icon="handshake" class="h-6 w-6 mr-2 text-gray-600" />
                    Borrowed Items
                </h2>
            </div>
        </template>

        <div class="py-6">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <!-- Search Input -->
                        <div class="mt-4 mb-4 relative">
                            <input
                                v-model.trim="searchQuery"
                                type="text"
                                placeholder="Search items via name, category, unit of measure, school level, room number, borrower, quantity, date borrowed, return date, status, or adviser"
                                class="w-full lg:w-2/3 xl:w-2/3 border rounded-md py-2 px-3 pl-7 text-sm"
                                style="outline: none;"
                            />
                            <svg
                                class="absolute left-3 top-3 h-4 w-4 text-gray-400 pointer-events-none"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M13.293 14.707a1 1 0 0 1-1.414 1.414l-3.793-3.793a5 5 0 1 1 1.414-1.414l3.793 3.793zM10 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="clipboard-list" class="h-6 w-6 mr-2 text-gray-600" />
                                        Name
                                        <button @click="sortBy('item_name')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('item_name')" 
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="tags" class="h-6 w-6 mr-2 text-gray-600" />
                                        Category
                                        <button @click="sortBy('category')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('category')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="balance-scale" class="h-6 w-6 mr-2 text-gray-600" />
                                        Unit of Measure
                                        <button @click="sortBy('unit_of_measure')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('unit_of_measure')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="graduation-cap" class="h-6 w-6 mr-2 text-gray-600" />
                                        School Level
                                        <button @click="sortBy('school_level')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('school_level')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="door-open" class="h-6 w-6 mr-2 text-gray-600" />
                                        Room Number
                                        <button @click="sortBy('room_number')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('room_number')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="user" class="h-6 w-6 mr-2 text-gray-600" />
                                        Borrower
                                        <button @click="sortBy('borrower')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('borrower')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="user" class="h-6 w-6 mr-2 text-gray-600" />
                                        Quantity
                                        <button @click="sortBy('quantity')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('quantity')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="calendar-plus" class="h-6 w-6 mr-2 text-gray-600" />
                                        Date Borrowed
                                        <button @click="sortBy('borrow_date')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('borrow_date')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="calendar-check" class="h-6 w-6 mr-2 text-gray-600" />
                                        Return Before
                                        <button @click="sortBy('return_date')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('return_date')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="info-circle" class="h-6 w-6 mr-2 text-gray-600" />
                                        Status
                                        <button @click="sortBy('status')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('status')" 
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="user-tie" class="h-6 w-6 mr-2 text-gray-600" />
                                        Adviser
                                        <button @click="sortBy('adviser')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('adviser')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="reply" class="mr-1"></font-awesome-icon>
                                        Returned?
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in paginatedItems" :key="item.id">
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ item.item_name }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.category }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.unit_of_measure }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.school_level }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.room_number }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.borrower }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.borrow_date }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.return_date }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.status }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.adviser }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                        <button @click="returnItem(item)" class="text-green-600 hover:text-green-900 ml-4">
                                            <font-awesome-icon icon="thumbs-up" title="Return without damage?"/>
                                        </button>
                                        <button @click="openDamageModal(item)" class="text-red-600 hover:text-red-900 ml-4">
                                            <font-awesome-icon icon="tools" title="With damage?"/>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- Damage Report Modal -->
                            <div v-if="showDamageModal" class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <!-- This element is to trick the browser into centering the modal contents. -->
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <font-awesome-icon icon="tools" class="text-red-600" />
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                        Report Damage
                                                    </h3>
                                                    <div class="mt-2">
                                                        <input v-model="damageReport.item_id" type="hidden" />
                                                        <input v-model="damageReport.item_name" type="hidden" />
                                                        <input v-model="damageReport.category" type="hidden" />
                                                        <input v-model="damageReport.unit_of_measure" type="hidden" />
                                                        <input v-model="damageReport.school_level" type="hidden" />
                                                        <input v-model="damageReport.room_number" type="hidden" />
                                                        <input v-model="damageReport.quantity" type="hidden" />
                                                        <input v-model="damageReport.adviser" type="hidden" />
                                                        <input v-model="damageReport.report_by" type="text" placeholder="Reported By" class="mt-1 block w-full" />
                                                        <input v-model="damageReport.description" type="text" placeholder="Description" class="mt-1 block w-full" />
                                                        Date Reported:
                                                        <input v-model="damageReport.date_reported" type="date" class="mt-1 block w-full" :disabled="true"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button @click="submitDamageReport" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Submit
                                            </button>
                                            <button @click="closeDamageModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination Controls -->
                            <div class="px-6 py-3 bg-white border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage *
                                         perPage, sortedAndFilteredItems.length) }} of {{ 
                                            sortedAndFilteredItems.length }} items
                                    </div>
                                    <div class="flex">
                                        <button @click="currentPage--" :disabled="currentPage === 1" class="px-3 py-1 mr-1 rounded-md bg-gray-200 hover:bg-gray-300 focus:outline-none">
                                            <font-awesome-icon icon="caret-left" class="h-6 w-6 mr-2 text-gray-600" 
                                            title="Previous"/>
                                        </button>
                                        <button @click="currentPage++" :disabled="currentPage * perPage >= 
                                            sortedAndFilteredItems.length" class="px-3 py-1 ml-1 rounded-md bg-gray-200 hover:bg-gray-300 focus:outline-none">
                                            <font-awesome-icon icon="caret-right" class="h-6 w-6 mr-2 text-gray-600" 
                                            title="Next"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faSort, faSortUp, faSortDown } from '@fortawesome/free-solid-svg-icons';

const { props } = usePage();
const items = ref(props.items);

const sortColumn = ref('');
const sortOrder = ref('asc'); // Initial sort order

// Font Awesome icons for sorting
const sortIcons = {
    asc: faSortUp,
    desc: faSortDown,
    '': faSort // Default icon when not sorting
};

// Method to toggle sorting order and sort by column
const sortBy = (column) => {
    if (column === sortColumn.value) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortOrder.value = 'asc';
    }
};

// Computed property to sort items based on current sort settings
const sortedItems = computed(() => {
    let sorted = [...items.value];

    if (sortColumn.value) {
        sorted = sorted.sort((a, b) => {
            const fieldA = a[sortColumn.value];
            const fieldB = b[sortColumn.value];

            if (fieldA < fieldB) {
                return sortOrder.value === 'asc' ? -1 : 1;
            }
            if (fieldA > fieldB) {
                return sortOrder.value === 'asc' ? 1 : -1;
            }
            return 0;
        });
    }

    return sorted;
});

// Method to determine which sort icon to display
const sortIcon = (column) => {
    if (column === sortColumn.value) {
        return sortIcons[sortOrder.value];
    } else {
        return sortIcons[''];
    }
};

const sortedAndFilteredItems = computed(() => {
    const sorted = sortedItems.value;
    const filtered = filteredItems.value;
    return sorted.filter(item => filtered.includes(item));
});

// State for search query
const searchQuery = ref('');

// Computed property to filter items based on search query
const filteredItems = computed(() => {
  const query = searchQuery.value.trim().toLowerCase();
  return items.value.filter(item =>
    item.item_name.toLowerCase().includes(query) ||
    item.category.toLowerCase().includes(query) ||
    item.unit_of_measure.toLowerCase().includes(query) ||
    item.school_level.toLowerCase().includes(query) ||
    item.room_number.toLowerCase().includes(query) ||
    item.borrower.toLowerCase().includes(query) ||
    item.quantity.toString().toLowerCase().includes(query) ||
    item.borrow_date.toLowerCase().includes(query) ||
    item.return_date.toLowerCase().includes(query) ||
    item.status.toLowerCase().includes(query) ||
    item.adviser.toLowerCase().includes(query)
  );
});

// Pagination constants
const perPage = ref(10); // Number of items per page
const currentPage = ref(1); // Current page number

// Computed property to paginate items
const paginatedItems = computed(() => {
    const startIndex = (currentPage.value - 1) * perPage.value;
    return sortedAndFilteredItems.value.slice(startIndex, startIndex + perPage.value);
});

// Method to return item
const returnItem = (item) => {
    // Find the item in the borrowedItems list
    const borrowedItemIndex = items.value.findIndex(borrowedItem => borrowedItem.id === item.id);
    if (borrowedItemIndex !== -1) {
        router.post(route('borrowed-items.return'), { item_id: item.item_id, quantity: item.quantity }, {
            onSuccess: () => {
                Swal.fire('Success', 'Item returned successfully', 'success');
                // Update the item's availability in the items list
                const itemIndex = items.value.findIndex(i => i.id === item.item_id);
                if (itemIndex !== -1) {
                    items.value[itemIndex].item_quantity += item.quantity;
                }
                // Remove the item from the borrowedItems list
                items.value.splice(borrowedItemIndex, 1);
            },
            onError: (error) => {
                Swal.fire('Error', 'Failed to return item', 'error');
                console.error('Return item error:', error);
            }
        });
    }
};

const showDamageModal = ref(false);
const selectedItem = ref(null);
const damageReport = ref({
  item_id: '',
  item_name: '',
  category: '',
  unit_of_measure: '',
  school_level: '',
  room_number: '',
  quantity: '',
  report_by: '',
  description: '',
  date_reported: '',
  adviser: ''
  });

const openDamageModal = (item) => {
  selectedItem.value = item;
  const now = new Date();
  now.setHours(now.getHours() + 8);
  damageReport.value = {
    item_id: item.id,
    item_name: item.item_name,
    category: item.category,
    unit_of_measure: item.unit_of_measure,
    school_level: item.school_level,
    room_number: item.room_number,
    quantity: item.quantity,
    report_by: '',
    description: '',
    date_reported: now.toISOString().split('T')[0],
    adviser: item.adviser
  };
  showDamageModal.value = true;
};

const closeDamageModal = () => {
  showDamageModal.value = false;
};

const submitDamageReport = () => {
  if (!damageReport.value.description || !damageReport.value.report_by) {
    Swal.fire('Error', 'All fields are required', 'error');
    return;
  }

  router.post(route('damaged-items.post'), damageReport.value, {
    onSuccess: () => {
      Swal.fire('Success', 'Item marked as damaged successfully', 'success');
      closeDamageModal();
      const itemIndex = items.value.findIndex(i => i.id === selectedItem.value.id);
      if (itemIndex !== -1) {
        items.value.splice(itemIndex, 1);
      }
    },
    onError: (error) => {
      Swal.fire('Error', 'Failed to mark item as damaged', 'error');
      console.error('Mark as damaged error:', error);
    }
  });
};

</script>

<style scoped>
.alert {
  padding: 1em;
  margin-bottom: 1em;
  border: 1px solid transparent;
  border-radius: 0.25em;
}

.alert-success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}

.text-center {
  text-align: center;
}

/* Styles for the search input */
.input-search {
  max-width: 20rem,
}

.input-search input {
  padding-left: 2.5rem;
}

.input-search svg {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
}
</style>
