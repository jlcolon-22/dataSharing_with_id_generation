<template>
    <div style="height: 650px;padding:30px 30px 100px 30px ; overflow-y: auto;">
        <div class="dashboard_header mt-2" >
            <h1 class="fw-bold">View Records</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Records</li>
                </ol>
            </nav>
        </div>
        <div class="row justify-content-center table-main" style="width: 100%;">
            <div class="col-md-12">
                <!-- <div class="input-group mb-3 col-sm-4" style="width: 30%;">
                    <label class="input-group-text"><b>Semester</b></label>
                    <select v-model="schoolyear" class="form-select">
                        <option selected class="text-secondary" value=""><b>Choose a semester...</b></option>
                        <option v-for="year in schoolYearData" :key="year.id" :value="year.school_year+' / '+year.semester" class="text-secondary">
                            {{ year.school_year + ' / ' + year.semester }}
                        </option>

                    </select>
                </div> -->
                <div class="table-responsive">
                    <table class="table table-hover table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th class=" text-center">ID</th>
                                <th class=" text-center">First Name</th>
                                <th class=" text-center">Middle Name</th>
                                <th class=" text-center">Last Name</th>
                                <th class=" text-center">School Year / Semester</th>
                                <th class=" text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.last_name }}</td>
                                <td>{{ user.middle_name }}</td>
                                <td>{{ user.first_name }}</td>
                                <td>{{ user.section }}</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- view modal -->
    <viewModal v-show="modalVisible" @close="closeModalView" :userInfo="userInfo" :view="view" />
    <editModal v-show="editModalVisible" @close="closeModalEdit" :edit="edit" :userInfo="userInfo"
        :editrecordvalue="editRecordValue" />
    <addModal v-show="addModalVisible" :userInfo="userInfo" :add="add" @close="closeModalAdd" @open-edit="openModalEdit" />
</template>

<script setup>
import { ref, onMounted, watchEffect, watch, reactive, onBeforeUnmount } from 'vue'
import { Modal } from 'bootstrap'
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

// import modal
import viewModal from "./ViewPatient.vue";
import editModal from "./EditPatient.vue";
import addModal from "./AddPatient.vue";
import axios from 'axios';

const users = ref([])
const userInfo = ref([])
const editRecordValue = ref([])
const modalVisible = ref(false);
const editModalVisible = ref(false);
const addModalVisible = ref(false);
const view = ref(false)
const edit = ref(false)
const add = ref(false)
const schoolyear = ref('');

const schoolYearData = ref([]);
const table = ref(null)
const modalEdit = ref(null)
const modalAdd = ref(null)
const thead = reactive({
    row1: 'Year Level',
    row2: 'Students'
})
const schoolYearDataWithSection = ref([]);
const onprocessDatas = ref([]);
const studentData = ref([])
// watch(schoolyear, async (newValue, oldValue) => {
//     if (newValue == '') return;
//     studentData.value = [];

//     const on_process = await axios.get('http://127.0.0.1:8000/newjson/on_process.json');
//     const data = on_process.data.data.filter(value =>{
//                     return value.school_year_semester == newValue;
//                 })

//     // $$$$$$$$ server side $$$$$$$$$$$$$
//     // processing: true,
//     //     serverSide: true,
//     //     pageLength: 10,
//     //     serverMethod: 'get',
//     //     ajax: {
//     //         "url": "http://127.0.0.1:8000/newjson/on_process.json",
//     //         "dataSrc": function (json) {
//     //             // console.log(json)
//     //             json.recordsTotal = json.meta.last_page;
//     //             json.recordsFiltered = json.meta.last_page;
//     //             const on_process = json.data.filter(value =>{
//     //                 return value.school_year_semester == newValue;
//     //             })

//     //             return on_process;
//     //         }
//     //     },
//     table.value.destroy();
//     table.value = $('#myTable').DataTable({
//         data: data,
//         responsive: true,
//         dom: "<'row'<'col-sm-12 col-md-9  'l><'col-sm-12  col-md-3'f>>" +
//             "<'row'<'col-sm-12  text-center'rt>>" +
//             "<'row'<'col-sm-12  text-center col-md-7'i><'col-sm-12 col-md-5'p>>" +
//             "<'row'<'col-sm-12  text-center col-md-12'B>>",
//         buttons: [
//             {
//                 extend: 'copy',
//                 className: 'btn btn-primary mr-1',
//                 text: '<i class="fas fa-copy"></i> Copy',
//                 title: 'Clinic Record',
//                 exportOptions: {
//                     columns: [0, 1, 2, 3]
//                 },
//             },
//             {
//                 extend: 'csv',
//                 className: 'btn btn-success mr-1',
//                 text: '<i class="fas fa-file-csv"></i> CSV',
//                 title: 'Clinic Record',
//                 exportOptions: {
//                     columns: [0, 1, 2, 3]
//                 },
//             },
//             {
//                 extend: 'pdf',
//                 className: 'btn btn-danger mr-1',
//                 text: '<i class="fas fa-file-pdf"></i> PDF',
//                 title: 'Clinic Record',
//                 exportOptions: {
//                     columns: [0, 1, 2, 3]
//                 },
//                 customize: function (doc) {
//                     console.log(doc.content)
//                     // doc.content.[0].margin = [12, 0, 0, 12];
//                     // doc.content.[0].alignment = 'center';

//                     doc.content[1].table.widths =
//                         Array(doc.content[1].table.body[0].length + 1).join('*').split('');
//                 }


//             },
//             {
//                 extend: 'print',
//                 className: 'btn btn-warning',
//                 text: '<i class="fas fa-print"></i> Print',
//                 title: 'Clinic Record',
//                 exportOptions: {
//                     columns: [0, 1, 2, 3]
//                 },
//             },
//         ],
//         initComplete: function () {
//             // Create a new toolbar container element
//             const toolbar = $("<div class='toolbar-container'></div>");
//             // Prepend the toolbar container to the first child row of the DataTables wrapper
//             $(".dataTables_wrapper .row:first-child").prepend(toolbar);
//         },
//         columns: [
//             { data: 'student_no' },
//             { data: 'first_name' },
//             { data: 'school_year_semester' },
//             // { data: 'section' },
//             // { data: 'enrollments_count' },
//             // Button for View
//             {
//                 data: null,
//                 render: (data, type, row) => {
//                     return `
//                     <button type="button" class="btn btn-primary view" data-bs-toggle="modal"
//                             data-bs-target="#viewModal"
//                             data-bs-whatever="@getbootstrap">View</button>


//                             <button type="button" class="btn btn-success add" data-bs-toggle="modal"
//                             data-bs-target="#addModal"
//                             data-bs-whatever="@getbootstrap">Add</button>



//                             `;
//                 },
//                 orderable: false,
//                 searchable: false,
//             },
//         ],
//     });
//     // view
//     $("#myTable").on("click", ".view", function () {
//         const rowIndex = table.value.row($(this).closest("tr")).index();
//         const rowData = table.value.row(rowIndex).data();
//         // pass the id of row click
//         openModalView(rowData.student_number);
//     });
//     // edit
//     $("#myTable").on("click", ".edit", function () {
//         const rowIndex = table.value.row($(this).closest("tr")).index();
//         const rowData = table.value.row(rowIndex).data();
//         // pass the id of row click
//         openModalEdit(rowData.student_number);
//     });
//     // add
//     $("#myTable").on("click", ".add", function () {
//         const rowIndex = table.value.row($(this).closest("tr")).index();
//         const rowData = table.value.row(rowIndex).data();
//         // pass the id of row click
//         openModalAdd(rowData.student_number);
//     });



// })
const viewStudent = async (section, s) => {

    const { data } = await axios.get('http://127.0.0.1:8000/newjson/enrolled.json');

    if (data.section_name == section && data.year_semester == s) {
        const newData = data.data.map(element => {
            return Object.assign(element, { section: section })
        });
        studentData.value = newData;

    } else {
        studentData.value = [];
    }

    await table.value.destroy();
    table.value = $('#myTable').DataTable({
        data: studentData.value,
        responsive: true,
        dom: "<'row'<'col-sm-12 col-md-8  text-center'l><'col-sm-12 text-center col-md-3'f>>" +
            "<'row'<'col-sm-12  text-center'rt>>" +
            "<'row'<'col-sm-12  text-center col-md-7'i><'col-sm-12 col-md-5'p>>" +
            "<'row'<'col-sm-12  text-center col-md-12'B>>",
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-primary mr-1',
                text: '<i class="fas fa-copy"></i> Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
            },
            {
                extend: 'csv',
                className: 'btn btn-success mr-1',
                text: '<i class="fas fa-file-csv"></i> CSV',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger mr-1',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                customize: function (doc) {
                    console.log(doc.content)
                    // doc.content.[0].margin = [12, 0, 0, 12];
                    // doc.content.[0].alignment = 'center';

                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }


            },
            {
                extend: 'print',
                className: 'btn btn-warning',
                text: '<i class="fas fa-print"></i> Print',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
            },
        ],
        initComplete: function () {
            // Create a new toolbar container element
            const toolbar = $("<div class='toolbar-container'></div>");
            // Prepend the toolbar container to the first child row of the DataTables wrapper
            $(".dataTables_wrapper .row:first-child").prepend(toolbar);
        },
        columns: [
            { data: 'student_number' },
            { data: 'section' },
            { data: 'full_name' },
            { data: 'school_year_\/_semester' },

            // { data: 'section' },
            // { data: 'enrollments_count' },
            // Button for View
            {
                data: null,
                render: (data, type, row) => {
                    return `
                    <button type="button" class="btn btn-primary view" data-bs-toggle="modal"
                            data-bs-target="#viewModal"
                            data-bs-whatever="@getbootstrap">View</button>


                            <button type="button" class="btn btn-success add" data-bs-toggle="modal"
                            data-bs-target="#addModal"
                            data-bs-whatever="@getbootstrap">Add</button>



                            `;
                },
                orderable: false,
                searchable: false,
            },
        ],
    });
    // view
    $("#myTable").on("click", ".view", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalView(rowData.student_number);
    });
    // edit
    $("#myTable").on("click", ".edit", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalEdit(rowData.student_number);
    });
    // add
    $("#myTable").on("click", ".add", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalAdd(rowData.student_number);
    });

    thead.row1 = "Student Name";
    thead.row2 = "Action";


}
// view modal function
const openModalView = async (rowId,sys) => {

    userInfo.value = studentData.value.find(value =>{
        return value.student_no == rowId && value.school_year_semester == sys;
    })

    view.value = true;

    modalVisible.value = true;
};
// close modal
const closeModalView = async () => {
    // hide modal
    userInfo.value = []
    view.value = false;
    modalVisible.value = false;
};

// view modal edit function
const openModalEdit = async (rowId) => {
    editModalVisible.value = await true
    addModalVisible.value = false
    add.value = false;
    edit.value = true;
    editRecordValue.value = rowId;
    modalAdd.value.hide()
    modalEdit.value.show()

    // console.log(modalEdit.value)

};
// close modal edit
const closeModalEdit = async () => {
    // hide modal
    modalEdit.value.hide();
    add.value = false;
    await openModalAdd(editRecordValue.value.student_id,editRecordValue.value.school_year_semester);

    editModalVisible.value = false;

};

// view modal add function
const openModalAdd = async (rowId,sys) => {
    // show modal
    userInfo.value = studentData.value.find(value =>{
        return value.student_no == rowId && value.school_year_semester == sys;
    })



    add.value = true;
    addModalVisible.value = true;
    modalAdd.value.show();
};
// close modal add
const closeModalAdd = async () => {
    // hide modal
    userInfo.value = [];
    view.value = false;
    addModalVisible.value = false;
};

const fetchUsers = async () => {

    const { data } = await axios.get('http://127.0.0.1:8000/newjson/on_process.json');

    studentData.value = data.data;
    console.log(data.data)

}
const fetchSchoolYear = async () => {
    const year = await axios.get('http://127.0.0.1:8000/json/schoolyear.json');

    // console.log(schoolyear.data)
    schoolYearData.value = year.data;




}
onMounted(async () => {
    modalEdit.value = await new Modal('#editModal')
    modalAdd.value = await new Modal('#addModal')
    // await fetchSchoolYear()
    await fetchUsers()

    // to avoid duplication
    table.value = $('#myTable').DataTable({
        data: studentData.value,
        responsive: true,
        dom: "<'row'<'col-sm-12 col-md-9  'l><'col-sm-12  col-md-3'f>>" +
            "<'row'<'col-sm-12  text-center'rt>>" +
            "<'row'<'col-sm-12  text-center col-md-7'i><'col-sm-12 col-md-5'p>>" +
            "<'row'<'col-sm-12  text-center col-md-12'B>>",
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-primary mr-1',
                text: '<i class="fas fa-copy"></i> Copy',
                title: 'Clinic Record',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
            },
            {
                extend: 'csv',
                className: 'btn btn-success mr-1',
                text: '<i class="fas fa-file-csv"></i> CSV',
                title: 'Clinic Record',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger mr-1',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                title: 'Clinic Record',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                customize: function (doc) {
                    console.log(doc.content)
                    // doc.content.[0].margin = [12, 0, 0, 12];
                    // doc.content.[0].alignment = 'center';

                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }


            },
            {
                extend: 'print',
                className: 'btn btn-warning',
                text: '<i class="fas fa-print"></i> Print',
                title: 'Clinic Record',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
            },
        ],
        initComplete: function () {
            // Create a new toolbar container element
            const toolbar = $("<div class='toolbar-container'></div>");
            // Prepend the toolbar container to the first child row of the DataTables wrapper
            $(".dataTables_wrapper .row:first-child").prepend(toolbar);
        },
        columns: [
            { data: 'student_no' },
            { data: 'first_name' },
            { data: 'middle_name' },
            { data: 'last_name' },
            { data: 'school_year_semester' },
            // { data: 'section' },
            // { data: 'enrollments_count' },
            // Button for View
            {
                data: null,
                render: (data, type, row) => {
                    return `
                    <button type="button" class="btn btn-primary view" data-bs-toggle="modal"
                            data-bs-target="#viewModal"
                            data-bs-whatever="@getbootstrap">View</button>


                            <button type="button" class="btn btn-success add" data-bs-toggle="modal"
                            data-bs-target="#addModal"
                            data-bs-whatever="@getbootstrap">Logs</button>



                            `;
                },
                orderable: false,
                searchable: false,
            },
        ],
    });
    // view
    $("#myTable").on("click", ".view", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalView(rowData.student_no,rowData.school_year_semester);
    });
    // edit
    $("#myTable").on("click", ".edit", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalEdit(rowData.student_no, rowData.school_year_semester);
    });
    // add
    $("#myTable").on("click", ".add", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalAdd(rowData.student_no,rowData.school_year_semester);
    });



});
onBeforeUnmount(()=>{
    table.value.destroy();
    table.value = null;
})
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
    width: 90%;
    margin: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 13rem;
}

.table-main {
    margin-top: 5rem
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


