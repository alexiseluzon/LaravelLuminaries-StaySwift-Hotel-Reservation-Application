<template>
    <Head title="Items" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <font-awesome-icon icon="clipboard-list" class="h-6 w-6 mr-2 text-gray-600" />
                    Items
                </h2>
            <!-- Add Item Button -->
                <button @click="openAddModal" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-md">
                    <font-awesome-icon icon="plus-circle" class="mr-2"></font-awesome-icon>
                    Add Item
                </button>
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
                                placeholder="Search items via name, category, unit of measure, school level, room number, adviser"
                                class="w-full lg:w-2/3 xl:w-1/2 border rounded-md py-2 px-3 pl-7 text-sm"
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
                                        <font-awesome-icon icon="check-circle" class="h-6 w-6 mr-2 text-gray-600" />
                                        Availability
                                        <button @click="sortBy('item_quantity')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('item_quantity')"
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
                                        <font-awesome-icon icon="user-tie" class="h-6 w-6 mr-2 text-gray-600" />
                                        Adviser
                                        <button @click="sortBy('adviser')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('adviser')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="handshake" class="h-6 w-6 mr-2 text-gray-600" />
                                        Borrowed Items
                                        <button @click="sortBy('borrowed_items')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('borrowed_items')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="warning" class="h-6 w-6 mr-2 text-gray-600" />
                                        Overdue Items
                                        <button @click="sortBy('overdue_items')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('overdue_items')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="tools" class="h-6 w-6 mr-2 text-gray-600" />
                                        Damaged Items
                                        <button @click="sortBy('damaged_items')" class="ml-1 focus:outline-none">
                                            <font-awesome-icon :icon="sortIcon('damaged_items')"
                                            title="Sort"></font-awesome-icon>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <font-awesome-icon icon="cog" class="mr-1"></font-awesome-icon>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in paginatedItems" :key="item.id">
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ item.item_name }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.item_quantity }}
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
                                        {{ item.adviser }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ totalBorrowedQuantities[item.id] || 0 }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.overdue_items }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                        {{ item.damaged_items }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                        <button @click="updateModal(item)" class="text-blue-600 hover:text-blue-900">
                                            <font-awesome-icon icon="edit" title="Update"
                                            class="mr-1"></font-awesome-icon>
                                        </button>
                                        <button @click="borrowModal(item)" class="text-green-600 hover:text-green-900">
                                            <font-awesome-icon icon="handshake" title="Borrow"
                                            class="mr-1"></font-awesome-icon>
                                        </button>
                                        <button @click="deleteItem(item.id)" class="text-red-600 hover:text-red-900">
                                            <font-awesome-icon icon="trash-alt" title="Delete"
                                            class="mr-1"></font-awesome-icon>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

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
                                            <font-awesome-icon icon="caret-left" title="Previous"
                                            class="h-6 w-6 mr-2 text-gray-600" />
                                        </button>
                                        <button @click="currentPage++" :disabled="currentPage * perPage >= 
                                            sortedAndFilteredItems.length" class="px-3 py-1 ml-1 rounded-md bg-gray-200 hover:bg-gray-300 focus:outline-none">
                                            <font-awesome-icon icon="caret-right" title="Next"
                                            class="h-6 w-6 mr-2 text-gray-600" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div v-if="showAddModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add Item</h3>
                        <div class="mt-2">
                            <input v-model="newItem.item_name" type="text" placeholder="Item name" class="mt-1 block w-full" />
                            Availability
                            <input v-model="newItem.item_quantity" type="number" class="mt-1 block w-full" />
                            <!-- Category Select -->
                            <select v-model="newItem.category" class="mt-1 block w-full">
                                <option value="" disabled>Select Category</option>
                                <option value="Classroom Items">Classroom Items</option>
                                <option value="Office Items">Office Items</option>
                                <option value="Library Items">Library Items</option>
                                <option value="Science Lab Items">Science Lab Items</option>
                                <option value="Art Room Items">Art Room Items</option>
                                <option value="Music Room Items">Music Room Items</option>
                                <option value="Gymnasium and Sports Items">Gymnasium and Sports Items</option>
                                <option value="Cafeteria Items">Cafeteria Items</option>
                                <option value="Maintenance Items">Maintenance Items</option>
                                <option value="Playground Items">Playground Items</option>
                                <option value="Miscellaneous Items">Miscellaneous Items</option>
                            </select>
                            <!-- Unit of Measure Select -->
                            <select v-model="newItem.unit_of_measure" class="mt-1 block w-full">
                                <option value="" disabled>Select Unit of Measure</option>
                                <option value="Sets">Sets</option>
                                <option value="Pieces">Pieces</option>
                                <option value="Packs">Packs</option>
                                <option value="Kits">Kits</option>
                            </select>
                            <!-- School Level Select -->
                            <select v-model="newItem.school_level" class="mt-1 block w-full">
                                <option value="" disabled>Select School Level</option>
                                <option value="Junior High School">Junior High School</option>
                                <option value="Senior High School">Senior High School</option>
                            </select>
                            <input v-model="newItem.room_number" type="number" placeholder="Room Number" 
                            class="mt-1 block w-full" />
                            <input v-model="newItem.adviser" type="text" placeholder="Adviser" 
                            class="mt-1 block w-full" />
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button @click="addItem" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:text-sm">
                            Add
                        </button>
                    </div>
                    <div class="mt-3 sm:mt-4">
                        <button @click="showAddModal = false" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Update Modal -->
        <div v-if="showUpdateModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Update Item</h3>
                        <div class="mt-2">
                            Item name:
                            <input v-model="currentItem.item_name" type="text" class="mt-1 block w-full" />
                            Availability:
                            <input v-model="currentItem.item_quantity" type="number" class="mt-1 block w-full" />
                            <!-- Category Select -->
                             Category:
                            <select v-model="currentItem.category" class="mt-1 block w-full">
                                <option value="" disabled>Select Category</option>
                                <option value="Classroom Items">Classroom Items</option>
                                <option value="Office Items">Office Items</option>
                                <option value="Library Items">Library Items</option>
                                <option value="Science Lab Items">Science Lab Items</option>
                                <option value="Art Room Items">Art Room Items</option>
                                <option value="Music Room Items">Music Room Items</option>
                                <option value="Gymnasium and Sports Items">Gymnasium and Sports Items</option>
                                <option value="Cafeteria Items">Cafeteria Items</option>
                                <option value="Maintenance Items">Maintenance Items</option>
                                <option value="Playground Items">Playground Items</option>
                                <option value="Miscellaneous Items">Miscellaneous Items</option>
                            </select>
                            <!-- Unit of Measure Select -->
                             Unit of measure:
                            <select v-model="currentItem.unit_of_measure" class="mt-1 block w-full">
                                <option value="" disabled>Select Unit of Measure</option>
                                <option value="Sets">Sets</option>
                                <option value="Pieces">Pieces</option>
                                <option value="Packs">Packs</option>
                                <option value="Kits">Kits</option>
                            </select>
                            <!-- School Level Select -->
                             School level:
                            <select v-model="currentItem.school_level" class="mt-1 block w-full">
                                <option value="" disabled>Select School Level</option>
                                <option value="Junior High School">Junior High School</option>
                                <option value="Senior High School">Senior High School</option>
                            </select>
                            Room number:
                            <input v-model="currentItem.room_number" type="number" class="mt-1 block w-full" />
                            Adviser:
                            <input v-model="currentItem.adviser" type="text" class="mt-1 block w-full" />
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button @click="updateItem" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:text-sm">
                            Update
                        </button>
                    </div>
                    <div class="mt-3 sm:mt-4">
                        <button @click="showUpdateModal = false" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrow Modal -->
        <div v-if="showBorrowModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Borrow Item</h3>
                        <div class="mt-2">
                            <input v-model="newBorrowItem.item_id" type="hidden" />
                            <input v-model="newBorrowItem.item_name" type="hidden" />
                            <input v-model="newBorrowItem.category" type="hidden" />
                            <input v-model="newBorrowItem.unit_of_measure" type="hidden" />
                            <input v-model="newBorrowItem.room_number" type="hidden" />
                            <input v-model="newBorrowItem.school_level" type="hidden" />
                            <input v-model="newBorrowItem.borrower" type="text" placeholder="Borrower" 
                            class="mt-1 block w-full" required/>
                            Quantity to be Borrowed
                            <input v-model="newBorrowItem.quantity" type="number" min="1" 
                            class="mt-1 block w-full" required/>
                            Date of Borrowing
                            <input v-model="newBorrowItem.borrow_date" type="date"
                            class="mt-1 block w-full" :disabled="true" @change="setReturnDateMin"/>
                            Return before
                            <input v-model="newBorrowItem.return_date" type="date"
                            class="mt-1 block w-full" :min="minReturnDate" required />
                            <input v-model="newBorrowItem.status" type="hidden" />
                            <input v-model="newBorrowItem.adviser" type="hidden" />
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button @click="borrowItem" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:text-sm">
                            Borrow
                        </button>
                    </div>
                    <div class="mt-3 sm:mt-4">
                        <button @click="showBorrowModal = false" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faSort, faSortUp, faSortDown } from '@fortawesome/free-solid-svg-icons';

const { props } = usePage();
const items = ref(props.items);

const checkLowStock = () => {
    const lowStockItems = items.value.filter(item => item.item_quantity <= 5);

    if (lowStockItems.length > 0) {
        const lowStockMessage = lowStockItems.map(item => `${item.item_name}: ${item.item_quantity} left`).join(
            '\n');
        Swal.fire({
            icon: 'warning',
            title: 'Low Stock Alert',
            text: `The following items are low in stock:\n${lowStockMessage}`,
            confirmButtonText: 'OK'
        });
    }
};

checkLowStock();

const totalBorrowedQuantities = ref({});

const fetchTotalBorrowedQuantities = async () => {
  try {
    const response = await fetch(route('borrowed-items.totalBorrowedQuantityPerItem'));
    const data = await response.json();
    data.forEach(item => {
      totalBorrowedQuantities.value[item.item_id] = item.total_quantity;
    });
  } catch (error) {
    console.error('Error fetching total borrowed quantities:', error);
  }
};

onMounted(() => {
  fetchTotalBorrowedQuantities();
});

// Fetch total overdue quantities per item
const fetchOverdueQuantities = async () => {
  try {
    const response = await fetch(route('borrowed-items.totalOverdueQuantitiesPerItem'));
    const overdueQuantities = await response.json();
    
    // Map overdue quantities to items
    items.value.forEach(item => {
      const overdueItem = overdueQuantities.find(o => o.item_id === item.id);
      item.overdue_items = overdueItem ? overdueItem.total_overdue : 0;
    });
  } catch (error) {
    console.error('Error fetching overdue quantities:', error);
    Swal.fire('Error!', 'Failed to fetch overdue quantities.', 'error');
  }
};

onMounted(() => {
  fetchOverdueQuantities();
});

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

// State for the add modal
const showAddModal = ref(false);
const newItem = ref({
  item_name: '',
  item_quantity: 0,
  category: '',
  unit_of_measure: '',
  school_level: '',
  room_number: '',
  adviser: ''
});

const openAddModal = () => {
  newItem.value = {
    item_name: '',
    item_quantity: 0,
    category: '',
    unit_of_measure: '',
    school_level: '',
    room_number: '',
    adviser: ''
  };
  showAddModal.value = true;
};

const addItem = () => {
    // Check if there's any existing item with the same name, category, unit of measure, school level, and room number
    const conflictItem = items.value.find(item => (
        item.item_name.toLowerCase() === newItem.value.item_name.toLowerCase() &&
        item.category.toLowerCase() === newItem.value.category.toLowerCase() &&
        item.unit_of_measure.toLowerCase() === newItem.value.unit_of_measure.toLowerCase() &&
        item.school_level.toLowerCase() === newItem.value.school_level.toLowerCase() &&
        item.room_number.toString().toLowerCase() === newItem.value.room_number.toString() &&
        item.adviser.toLowerCase() === newItem.value.adviser.toString()
    ));

    if (conflictItem) {
        Swal.fire('Duplicate!', 'An item with the same details already exists. You should check it first', 'error');
        return;
    }

    // Proceed with adding the item if no conflicts found
  router.post(route('items.store'), newItem.value, {
    onSuccess: () => {
      showAddModal.value = false;
      router.get(route('items.index'));
      Swal.fire('Added!', 'The item has been added.', 'success');
    },
    onError: (error) => {
      console.error('Error adding item:', error);
      Swal.fire('Error!', 'An error occurred while adding the item.', 'error');
    }
  });
};

// State for the update modal
const currentItem = ref({});
const showUpdateModal = ref(false);

const updateModal = (item) => {
    currentItem.value = { ...item };
    showUpdateModal.value = true;
};

const updateItem = () => {
    // Check if there's any existing item with the same name, category, unit of measure, school level, and room number
    const conflictItem = items.value.find(item => (
        item.id !== currentItem.value.id &&
        item.item_name === currentItem.value.item_name &&
        item.category === currentItem.value.category &&
        item.unit_of_measure === currentItem.value.unit_of_measure &&
        item.school_level === currentItem.value.school_level &&
        item.room_number === currentItem.value.room_number &&
        item.adviser === currentItem.value.adviser
    ));

    if (conflictItem) {
        Swal.fire('Duplicate!', 'An item with the same details already exists. You should check it first', 'error');
        return;
    }

    // Proceed with updating the item if no conflicts found
    router.put(route('items.update', { item: currentItem.value.id }), currentItem.value, {
        onSuccess: () => {
            showUpdateModal.value = false;
            items.value = items.value.map(item => item.id === currentItem.value.id ? currentItem.value : item);
            router.get(route('items.index'));
            Swal.fire('Updated!', 'The item has been updated.', 'success');
        },
        onError: (error) => {
            console.error('Error updating item:', error);
            Swal.fire('Error!', 'An error occurred while updating the item.', 'error');
        }
    });
};

// State for the borrow modal
const showBorrowModal = ref(false);
const selectedItem = ref({});
const newBorrowItem = ref({
  item_id: '',
  item_name: '',
  category: '',
  unit_of_measure: '',
  school_level: '',
  room_number: '',
  borrower: '',
  borrow_date: '',
  return_date: '',
  status: '',
  adviser: '',
  quantity: 1
});

// State for the minimum return date
const minReturnDate = ref('');

const setReturnDateMin = () => {
    if (newBorrowItem.value.borrow_date) {
        const borrowDate = new Date(newBorrowItem.value.borrow_date);
        borrowDate.setDate(borrowDate.getDate() + 1);
        minReturnDate.value = borrowDate.toISOString().split('T')[0];
        if (new Date(newBorrowItem.value.return_date) <= borrowDate) {
            newBorrowItem.value.return_date = '';
        }
    }
};

onMounted(() => {
    // Initialize the borrow date to the current date
    const today = new Date();
    today.setHours(today.getHours() + 8);
    today.toISOString().split('T')[0];
    newBorrowItem.value.borrow_date = today;
    setReturnDateMin();
});

const borrowModal = (item) => {
    selectedItem.value = item;
    const now = new Date();
    now.setHours(now.getHours() + 8);
    newBorrowItem.value = {
    item_id: parseInt(item, 10),
    item_id: item.id,
    item_name: item.item_name,
    category: item.category,
    unit_of_measure: item.unit_of_measure,
    room_number: item.room_number,
    school_level: item.school_level,
    borrower: '',
    borrow_date: now.toISOString().split('T')[0],
    return_date: '',
    status: 'Borrowed',
    adviser: item.adviser,
    quantity: 1
};
    showBorrowModal.value = true;
};

const borrowItem = () => {
    if (!newBorrowItem.value.borrower || !newBorrowItem.value.return_date) {
        Swal.fire('Error!', 'All fields are required.', 'error');
        return;
    }

    if (newBorrowItem.value.quantity > selectedItem.value.item_quantity) {
        Swal.fire('Error!', 'Not enough stock available.', 'error');
        return;
    }
    
    router.post(route('borrowed-items.store'), newBorrowItem.value, {
    onSuccess: () => {
      showBorrowModal.value = false;
      router.get(route('items.index'));
      Swal.fire('Borrowed!', 'The item has been borrowed. Check your borrowed items in the Borrowed Items tab', 'success');
    },
    onError: (error) => {
      console.error('Error adding item:', error);
      Swal.fire('Error!', 'An error occurred while borrowing the item.', 'error');
    }
  });
};

const deleteItem = (itemId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to delete this item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('items.destroy', { item: itemId }), {
                onSuccess: () => {
                    items.value = items.value.filter(item => item.id !== itemId);
                    Swal.fire('Deleted!', 'The item has been deleted.', 'success');
                },
                onError: (error) => {
                    console.error('Error deleting item:', error);
                    Swal.fire('Error!', 'An error occurred while deleting the item.', 'error');
                }
            });
        }
    });
};

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
