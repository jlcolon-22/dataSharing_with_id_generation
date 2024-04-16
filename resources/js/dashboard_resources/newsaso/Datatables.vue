<template>
    <div  style="max-height: calc(100vh - 80px);padding:30px 30px 100px 30px ; overflow-y: auto;overflow-x: hidden;">
        <!-- view modal -->

        <div class="dashboard_header">
            <h1 class="fw-bold">View Records</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Student Records {{ dataId }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center table-main ">
            <div class="col-md-12">
                <div class="table-responsive" >
                    <div    >
                        <button v-show="selectedIds.length != 0" type="button" class="btn btn-success w-100 mt-3 fw-bold generate-id-button" @click="handleGenerateId" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-id-card-clip fa-flip fa-xl"></i> Generate ID
                        <span v-show="selectedIds.length != 0" class="badge text-bg-danger">
                            {{ selectedIds.length }}</span>

                    </button>
                    </div>
                    <!-- <div class="input-group mb-3 col-sm-4" style="width: 30%;">
                            <label class="input-group-text"><b>Semester</b></label>
                            <select class="form-select" v-model="selectedYear">
                                <option selected class="text-secondary"><b>Choose a semester...</b></option>
                                <option class="text-secondary" v-for="semester in semesters" :key="semester" :value="semester">
                                    {{ semester }}
                                </option>
                            </select>
                    </div> -->
                    <table class="table table-hover table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th>Generate</th>
                                <th>Student-ID</th>
                                <th>Last Name</th>
                                <th>Middle Name</th>
                                <th>First Name</th>
                                <!-- <th>Suffix</th> -->
                                <th>School Year / Semester</th>
                                <!-- <th>Guardian's Name</th>
                                <th>Guardian's Address</th>
                                <th>Guardian's Contact</th> -->
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <Upload v-show="addModalVisible" :upload="upload" :userInfo="userInfo" @close="closeModalAdd" />
    <previewID v-show="previewIdVisible" :preview="preview" :userInfo="userInfo" @close="closeModalPreview" />
    <View v-show="viewModalVisible" :view="view" :userInfo="userInfo" @close="closeModalView" />
    <Generate :bulkPreviewModal="bulkPreviewModal" :ids="selectedIds" @close="closeGenerate" />
</template>
<script setup>
import {
    ref,
    onMounted,
    onBeforeUnmount,
    computed,
    reactive,
    watch,
} from "vue";
import axios from "axios";

// Import the required DataTables styles
import "datatables.net";
import "datatables.net-responsive";
import 'datatables.net-buttons-dt';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';
import 'datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css';
import 'datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css';

// Import the required DataTables scripts
import $ from 'jquery';
import 'jszip';
import 'pdfmake';
import 'datatables.net';
import 'datatables.net-bs4';
import 'datatables.net-buttons';
import 'datatables.net-buttons-bs4';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive';
import 'datatables.net-responsive-bs4';



import Upload from '../../dashboard_resources/newsaso/Upload.vue'
import previewID from '../../dashboard_resources/newsaso/PreviewId.vue'
import View from '../../dashboard_resources/newsaso/ViewInformation.vue'
import Generate from '../../dashboard_resources/newsaso/Generate.vue'
import { Modal } from 'bootstrap';
const modalUpload = ref(null)
const modalPreviewId = ref(null)
const modalView = ref(null)
const modalbulkPreviewModal = ref(null)

const upload = ref(false)
const preview = ref(false)
const view = ref(false)
const bulkPreviewModal = ref(false)
const selectedIds = ref([]);

// data-id
const data_id = ref(null);
const table = ref(null)
const studentData = ref([]);
const userInfo = ref([]);
const id_Gen = ref([]);
const viewModalVisible = ref(false);
const addModalVisible = ref(false);
const previewIdVisible = ref(false);

const dataId = ref(null);


// view modal function
const openModalView = async (rowId, sys) => {
    // show modal
    const x = studentData.value.find(value => {
        return value[0].student_no == rowId && value[0].school_year_semester == sys;
    })
    userInfo.value = x[0]

    viewModalVisible.value = true;
    view.value = true;
    modalView.value.show();
};
// close modal
const closeModalView = async () => {
    modalView.value.hide();
    userInfo.value = []

    viewModalVisible.value = false;
    view.value = false;

};
// view modal add function
const openModalAdd = async (rowId, sys) => {
    // show modal
    userInfo.value = [];
    const x = studentData.value.find(value => {
        return value[0].student_no == rowId && value[0].school_year_semester == sys;
    })
    userInfo.value = x[0]
    addModalVisible.value = true;
    upload.value = true;
    modalUpload.value.show();

};
// close modal add
const closeModalAdd = async () => {
    // hide modal
    modalUpload.value.hide();
    addModalVisible.value = false;
    upload.value = false;
    userInfo.value = [];


};
// view modal add function
const openModalPreview = async (rowId, sys) => {
    // show modal
    const x = studentData.value.find(value => {
        return value[0].student_no == rowId && value[0].school_year_semester == sys;
    })
    userInfo.value = x[0]
    previewIdVisible.value = true;
    preview.value = true;
    modalPreviewId.value.show();

};
// close modal add
const closeModalPreview = async () => {
    // hide modal
    modalPreviewId.value.hide();
    userInfo.value = []
    previewIdVisible.value = false;
    preview.value = false;

};

// fetch data from ON_PROCESS JSON
const fetchUsers = async () => {
    const res = await axios.get('http://127.0.0.1:8000/newjson/on_process.json')
    studentData.value = res.data.data;

    const response = await axios.get('/api/saso/status');
    const allSaso = response.data;
    const students = [];
    studentData.value.forEach(value =>{
        var x = [];

        if(allSaso.length > 0)
        {
            const find = allSaso.find(s =>{
                return s.student_id == value.student_no && s.school_year_semester == value.school_year_semester
            })
           if(!!find)
           {
                      x = [...x,value,{status:find.status}]
                    students.push(x)
           }else{
                      x = [...x,value,{status:0}]
                    students.push(x)
           }
        }else{
            x = [...x,value,{status:0}]
            students.push(x)


        }
    })
    studentData.value = students;
    console.log(studentData.value)

};

// Open generate Modal
const handleGenerateId = async () => {
    bulkPreviewModal.value = true;
    modalbulkPreviewModal.value.show();
}

// close generate Modal
const closeGenerate = async () => {

    modalbulkPreviewModal.value.hide()
    bulkPreviewModal.value = false;
    window.location.reload(true);
}
onMounted(async () => {
    modalUpload.value = new Modal('#addModal')
    modalPreviewId.value = new Modal('#previewIdModal')
    modalView.value = new Modal('#viewModal')
    modalbulkPreviewModal.value = new Modal('#bulkPreviewModal')

    await fetchUsers()
    // Initialize DataTable
    table.value = $("#myTable").DataTable({
        data: studentData.value, // Use the computed property here
        order: [[6, 'desc']],
        // Your DataTable initialization options here
        responsive: true,
        dom:
            "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'rt>>" +
            "<'row'<'col-sm-12 col-md-7'i><'col-sm-12 col-md-5'p>>" +
            "<'row'<'col-sm-12 col-md-12'B>>",
        buttons: [
            {
                extend: "copy",
                className: "btn btn-primary mr-1",
                text: '<i class="fas fa-copy"></i> Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3,4,5,6]
                },
            },
            {
                extend: "csv",
                className: "btn btn-success mr-1",
                text: '<i class="fas fa-file-csv"></i> CSV',
                exportOptions: {
                    columns: [0, 1, 2, 3,4,5,6]
                },
            },
            {
                extend: "pdf",
                className: "btn btn-danger mr-1",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3,4,5,6]
                },
            },
            {
                extend: "print",
                className: "btn btn-warning",
                text: '<i class="fas fa-print"></i> Print',
                exportOptions: {
                    columns: [0, 1, 2, 3,4,5,6]
                },
            },
        ],

        columns: [
            // checkbox for generate id
            {
                data: null,
                render: (data, type, row) => {

                    return `
                            <th scope="row">
                                <input class="form-check-input"  type="checkbox" data-id="${row[0].student_no}" data-sys="${row[0].school_year_semester}">
                                PID: ${row[0].student_no}
                            </th>
                                `;
                },
            },
            {
                data: null,
                render: (data, type, row) => {

                    return `${row[0].student_no}`;
                },
            },

            {
                data: null,
                render: (data, type, row) => {

                    return `${row[0].last_name}`;
                },
            },

            {
                data: null,
                render: (data, type, row) => {

                    return `${row[0].middle_name}`;
                },
            },

            {
                data: null,
                render: (data, type, row) => {

                    return `${row[0].first_name}`;
                },
            },
            {
                data: null,
                render: (data, type, row) => {

                    return `${row[0].school_year_semester}`;
                },
            },
            {
                data: null,
                render: (data, type, row) => {
                     if (row[1].status == 1)  {
                    return `<span class="badge text-bg-success p-2">Generated ID</span>`;
                     } else {
                         return `<span class="badge text-bg-warning p-2">Not Generated ID</span>`;
                     }
                },
            },

            {
                data: null,
                render: (data, type, row) => {
                    return `
                                    <div style="display: flex; gap: .5rem">
                                        <button type="button" class="btn btn-primary pop" >
                                            View
                                        </button>
                                        <button type="button" class="btn btn-warning preview" d>
                                            ID
                                        </button>
                                        <button type="button" class="btn btn-success add" >
                                            Upload
                                        </button>
                                    </div>
                                `;
                },
                orderable: false,
                searchable: false,
            },
        ],
        initComplete: function () {
            // Create a new toolbar container element
            const toolbar = $(
                "<div class='toolbar-container'></div>"
            );
            // Prepend the toolbar container to the first child row of the DataTables wrapper
            $(".dataTables_wrapper .row:first-child").prepend(
                toolbar
            );

            // Event handler for checkbox change
            $(document).ready(function () {
                $("#myTable").on(
                    "change",
                    ".form-check-input",
                    function () {
                        // const id = $(this).data("id");
                        const id = $(this).data("id");
                        const sys = $(this).data("sys");
                        const row = $(this).closest("tr"); // Get the closest row element

                        if ($(this).is(":checked")) {
                            selectedIds.value.push({ id: id, sys: sys });
                        } else {
                            // Remove the selected ID from the array if unchecked
                            // const index = selectedCheckboxes.pids.indexOf(id);
                            // Remove the selected ID and row from the arrays if unchecked
                            selectedIds.value = selectedIds.value.filter(value => {

                                if (value.id == id && value.sys == sys) {

                                } else {
                                    return value;
                                }

                            });


                        }


                    }
                );
            });
        },
        // ...
    });
    // Event handlers for view and add buttons
    $("#myTable").on("click", ".view", function () {
        // console.log(this.value.dataset.id)
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();


    });

    // view
    $("#myTable").on("click", ".pop", async function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        openModalView(rowData[0].student_no, rowData[0].school_year_semester);
    });

    // ID
    $("#myTable").on("click", ".preview", async function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        data_id.value = this.getAttribute("data-id");
        // pass the id of row click
        // openModalView(data_id);
        openModalPreview(rowData[0].student_no, rowData[0].school_year_semester)
    });

    // add
    $("#myTable").on("click", ".add", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();

        // pass the id of row click
        openModalAdd(rowData[0].student_no, rowData[0].school_year_semester);
        // Emit the custom event with the ID for going back
        // t/his.$emit("open-modal-add", rowData.id);
    });
});




</script>
<style scoped>
/* Main container */
.main-container {
    width: 90%;
    margin: auto;
}

/* Design for dashboard header */
div.dashboard_header {
    width: 80% !important;
    position: sticky;
    left: 0;
    right: 0;
    width: 100%;
    height: 1rem;
    padding: 10px;
    box-sizing: border-box;
    margin-bottom: 1rem;
    /* Add margin-bottom to create space below the header */
    /* border: 1px solid red;  */
}

/* Design for the data-table */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f2f2f2;
}

/* Design for the generated button ID */
.generate-id-button {

    display: flex;
    justify-content: center;
    align-items: center;

    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
}

.generate-id-button:hover {
    background-color: #45a049;
}

/* Style for the ID card icon */
.generate-id-button i {
    margin-right: 0.5rem;
}

.table-main {
    margin-top: 5rem;
}

.popup-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 2rem;
}

/* Create a backdrop for the popup */
.popup-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 999;
    display: flex;
    justify-content: center;
    align-items: center;
}

button.popup-close {
    border: 1px solid red
}

.rounded-top {
    background-color: rgb(95, 178, 95);
    color: #ffffff;
    padding: 0.5rem;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

@media screen and (max-width: 1480px) {
    .generate-id-button {
        max-width: 100% !important;
        margin-top: 1rem !important;
        margin-left: 0;
    }

    div.dashboard_header {
        margin-left: 0rem !important;
    }

    .table-main {
        width: 100%;
        margin-left: 0rem !important;
        margin-right: 0rem;
        margin-top: 5rem !important;
    }
}
</style>
