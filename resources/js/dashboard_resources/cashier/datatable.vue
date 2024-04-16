<template>
    <div style="height: 650px;padding:30px 20px 100px 30px; overflow-y: scroll;">
        <div class="dashboard_header mt-2" >
            <h1 class="fw-bold">View Records</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Records</li>
                </ol>
            </nav>
        </div>
        <!-- Sorting -->
        <div class="row table-main" style="width: 100%;">
                <!-- <div class="input-group mb-3 col-sm-4" style="width: 30%;">
                    <label class="input-group-te xt"><b>Semester</b></label>
                    <select class="form-select" v-model="currentSem">
                        <option selected value="" class="text-secondary"><b>Choose a semester...</b></option>
                        <option v-for="year in schoolYearData" :key="year.id" class="text-second ary" :value="year.id">
                            {{ year.school_year + ' / ' + year.semester }}
                        </option>

                    </select>
                </div> -->
            <div cl ass="col-md-12">
                <div class="table-responsive " >
                    <table class="table table-hover w-100 table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>School Year</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- view modal -->
    <viewModal v-show="modalVisible" :userInfo="userInfo" :view="view" @close="closeModalView" />
    <addModal v-show="addModalVisible" @close="closeModalAdd" :add="add" :userInfo="userInfo" />
    <updateModal v-show="updateModalVisible" :userInfo="userInfo" :update="update" @close="closeModalUpdate" />
    <previewModal v-show="previewModalVisible" :userInfo="userInfo" :preview="preview" @close="closeModalPreview" />
</template>
<script setup>





import { ref, onMounted, watchEffect, watch, onBeforeMount, reactive } from 'vue'

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
import viewModal from "./ViewStudentsInformation.vue";
import addModal from "./AddPayment.vue";
import updateModal from "./UpdatePayment.vue"
import previewModal from "./PreviewAssesment.vue"
import { Modal } from 'bootstrap';
// check
const view = ref(false);
const add = ref(false);
const update = ref(false);
const preview = ref(false);

const users = ref([])
const userInfo = ref([]);
const currentSem = ref('');
const modalVisible = ref(false);
const addModalVisible = ref(false);
const updateModalVisible = ref(false);
const previewModalVisible = ref(false);
const schoolYearData = ref([]);
const table = ref(null)
const studentData = ref([])
const schoolYearDataWithSection = ref([])

// datatable button
const modalView = ref(null)
const modalAdd = ref(null)
const modalUpdate = ref(null)
const modalPreview = ref(null)

watch(currentSem, async (newValue, oldValue) => {
    // thead.row1 = "Year Level";
    // thead.row2 = "Students";
    if(newValue == '') return;
    studentData.value = [];
    const year = schoolYearData.value.filter(value => {
        return value.id == newValue;
    })
    const sections = await axios.get('http://127.0.0.1:8000/newjson/sections.json');

    const withSection = sections.data.filter(value => {
        if (value.school_year_id == year[0].id) {
            return Object.assign(value, { schoolyear: year[0] });
        }
    })


    // console.log(withSection[0])
    schoolYearDataWithSection.value = withSection;
    table.value.destroy();
    table.value = $('#myTable').DataTable({
        data: withSection,
        responsive: true,
        dom: "<'row'<'col-sm-12 col-md-8  text-center'l><'col-sm-12 col-md-3  text-center'f>>" +
            "<'row'<'col-sm-12  text-center'rt>>" +
            "<'row'<'col-sm-12  text-center col-md-7'i><'col-sm-12  text-center col-md-5'p>>" +
            "<'row'<'col-sm-12  text-center col-md-12'B>>",
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-primary mr-1',
                text: '<i class="fas fa-copy"></i> Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
            },
            {
                extend: 'csv',
                className: 'btn btn-success mr-1',
                text: '<i class="fas fa-file-csv"></i> CSV',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger mr-1',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function (doc) {

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
                    columns: [0, 1, 2, 3, 4]
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
            { data: 'id' },
            { data: 'section_name' },
            { data: 'year_level' },
            { data: 'school_year_/_semester' },
            // { data: 'enrollments_count' },
            // Button for View
            {
                data: null,
                render: (data, type, row) => {

                    return `
                            <a  type="button" class="viewStudent"
                           >${data.enrollments_count} Students</a>



                            `;
                },
                orderable: false,
                searchable: false,
            },
        ],
    });
    // view
    $("#myTable").on("click", ".viewStudent", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        // openModalView(rowData.id);
        viewStudent(rowData.section_name, rowData['school_year_\/_semester'])
    });



})


// view Student Function
const viewStudent = async (section, s) => {

const { data } = await axios.get('http://127.0.0.1:8000/newjson/enrolled.json');

if (data.section_name == section && data.year_semester == s) {
    const newData = data.data.map(element => {
        return Object.assign(element,{section: section})
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
        { data: 'student_no' },
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
                <button type="button" class="btn btn-primary view"
                            data-bs-whatever="@getbootstrap">View</button>

                            <button type="button" class="btn btn-success add"
                            data-bs-whatever="@getbootstrap">Add</button>

                            <button type="button" class="btn btn-warning update"
                            data-bs-whatever="@getbootstrap">Update</button>

                            <button type="button" class="btn btn-secondary preview"
                            data-bs-whatever="@getbootstrap">Preview</button>



                        `;
            },
            orderable: false,
            searchable: false,
        },
    ],
});
    $("#myTable").on("click", ".view", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click
        openModalView(rowData.student_no);
    });
    $("#myTable").on("click", ".add", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the student_no of row click
        openModalAdd(rowData.student_no);
    });
    $("#myTable").on("click", ".update", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the student_no of row click
        openModalUpdate(rowData.student_no);
    });
    $("#myTable").on("click", ".preview", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the student_no of row click
        openModalPreview(rowData.student_no);
    });

// thead.row1 = "Student Name";
// thead.row2 = "Action";


}


// view modal function
const openModalView = async (rowId,sys) => {
    const res = studentData.value.filter(value => {
        return value.student_no == rowId && value.school_year_semester == sys;
    })
    console.log(sys)
    userInfo.value = res[0];
    view.value = true;
    // show modal
    modalVisible.value = true;
    modalView.value.show();
};
// close modal
const closeModalView = async () => {
    // hide modal
    modalView.value.hide()
    userInfo.value = [];
    view.value = false;
    modalVisible.value = false;
};

// view modal add function
const openModalAdd = async (rowId,sys) => {
    // show modal
    const res = studentData.value.filter(value => {
        return value.student_no == rowId && value.school_year_semester == sys;;
    })
    add.value = true;
    userInfo.value = res[0];
    addModalVisible.value = true;
    modalAdd.value.show()
};
// close modal add
const closeModalAdd = async () => {
    // hide modal
    modalAdd.value.hide()
    userInfo.value = []
    add.value = false
    addModalVisible.value = false;

};
// view modal update function
const openModalUpdate = async (rowId,sys) => {
    const res = studentData.value.filter(value => {
        return value.student_no == rowId && value.school_year_semester == sys;;
    })
    userInfo.value = res[0];

    // show modal

    update.value = true;
    // show modal
    updateModalVisible.value = true;
    modalUpdate.value.show();

};
// close modal add
const closeModalUpdate = async () => {
    modalUpdate.value.hide()
    // hide modal
    userInfo.value = [];
    update.value = false;
    updateModalVisible.value = false;

};
// view modal preview assesment function
const openModalPreview = async (rowId,sys) => {
    const res = studentData.value.filter(value => {
        return value.student_no == rowId && value.school_year_semester == sys;;
    })
    userInfo.value = res[0];
    // show modal
    preview.value = true;
    previewModalVisible.value = true;
    modalPreview.value.show()
};
// close modal add
const closeModalPreview = async () => {
    userInfo.value = [];

    // hide modal
    closeModalPreview.value = false;
};

// reset props data


const fetchUsers = async () => {

    const { data } = await axios.get('http://127.0.0.1:8000/newjson/on_process.json');

    studentData.value = data.data;


}

const fetchSchoolYear = async () => {
    const year = await axios.get('http://127.0.0.1:8000/json/schoolyear.json');

    // console.log(schoolyear.data)
    schoolYearData.value = year.data;

}
onMounted(async () => {
    modalView.value = new Modal('#viewModal');
    modalAdd.value = new Modal('#addModal');
    modalUpdate.value = new Modal('#updateModal');
    modalPreview.value = new Modal('#previewModal');
    // to avoid duplication
    await fetchUsers()

    // get all available semester


    table.value = $('#myTable').DataTable({
    data: studentData.value,
    responsive: true,
    dom: "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 text-center col-md-3'f>>" +
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
                <button type="button" class="btn btn-primary view"
                            data-bs-whatever="@getbootstrap">View</button>

                            <button type="button" class="btn btn-success add"
                            data-bs-whatever="@getbootstrap">Add</button>

                            <button type="button" class="btn btn-warning update"
                            data-bs-whatever="@getbootstrap">Update</button>

                            <button type="button" class="btn btn-secondary preview"
                            data-bs-whatever="@getbootstrap">Preview</button>



                        `;
            },
            orderable: false,
            searchable: false,
        },
    ],
});
    $("#myTable").on("click", ".view", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the id of row click

        openModalView(rowData.student_no,rowData.school_year_semester);
    });
    $("#myTable").on("click", ".add", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();

        // pass the student_no of row click
        openModalAdd(rowData.student_no,rowData.school_year_semester);
    });
    $("#myTable").on("click", ".update", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the student_no of row click
        openModalUpdate(rowData.student_no,rowData.school_year_semester);
    });
    $("#myTable").on("click", ".preview", function () {
        const rowIndex = table.value.row($(this).closest("tr")).index();
        const rowData = table.value.row(rowIndex).data();
        // pass the student_no of row click
        openModalPreview(rowData.student_no,rowData.school_year_semester);
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

}</style>


