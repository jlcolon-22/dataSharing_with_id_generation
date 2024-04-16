<template>
    <div class="modal fade" id="previewIdModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style=" background-color: rgb(95, 178, 95);">
                    <h5 class="modal-title text-light">Edit Templates</h5>
                    <button type="button" class="btn-close" @click="$emit('close')"></button>
                </div>
                <div class="modal-body">
                    <div v-show="check == true" class="alert alert-warning">
                        <strong>You need to upload a profile image and signature before you can start using these
                            features.!</strong>
                    </div>
                    <div v-show="checkTemplate == true" class="alert alert-warning">
                        <strong>No Available Template!</strong>
                    </div>
                    <!-- toolbar -->
                    <div v-if="check == false && checkTemplate == false" class="d-flex justify-content-between p-6">
                        <div class="d-flex gap-2 col-md-2  rounded" style="padding-bottom: 20px;">
                            <div class="dropdown">
                                <button class="btn border dropdown-toggle" type="button" id="dropdownMenu2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Font Size <span class="badge badge text-bg-success " style="margin-left: 5px;">{{
                                        selectedFont }}</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                    style="max-height: 300px; overflow-y: auto;">
                                    <li v-for="font in fontSizes" :key="font"><button @click="pickFont(font)"
                                            class="dropdown-item" type="button">{{ font }}</button></li>
                                </ul>
                            </div>


                        </div>
                        <div class="col-md-8 border rounded d-flex">
                            <!-- For font family dropdown -->
                            <div class="container  mx-auto  gap-3" style="display: flex;flex-wrap: wrap ;">
                                <!-- Your Font Family Dropdown Menu -->
                                <section class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <div class="text-secondary">
                                            Font Size
                                        </div>

                                    </div>
                                    <div class="dropdown">
                                        <div class="btn btn-white">
                                            <b>:</b>
                                        </div>

                                    </div>
                                    <div class="dropdown me-2">
                                        <div class="text-success">
                                            <!-- <b v-if="selectedFontSize">{{ selectedFontSize }} pt</b> -->
                                            <b>{{ selected.fw }} pt</b>
                                        </div>

                                    </div>
                                    <div class="dropdown">
                                        <div class="btn btn-white">
                                            <b class="text-secondary">|</b>
                                        </div>

                                    </div>
                                </section>

                                <!-- Your Font Family Dropdown Menu -->
                                <section class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <div class="text-secondary">
                                            Font Family
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <div class="btn btn-white">
                                            <b>:</b>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <div class="text-success">
                                            <!-- <b v-if="selectedFontFamily">{{ selectedFontFamily }}</b> -->
                                            <b>{{ selected.ff }}</b>
                                        </div>

                                    </div>
                                    <div class="dropdown">
                                        <div class="btn btn-white">
                                            <b class="text-secondary">|</b>
                                        </div>
                                    </div>
                                </section>


                                <!-- Height -->
                                <section class="d-flex align-items-center">

                                    <div class="dropdown">
                                        <div class="btn btn-white">
                                            <b class="text-secondary">Selected : </b>
                                            <!-- <b class="text-success">{{ 'selectedContent' }} </b> -->
                                            <b class="text-success">{{ selected.content }} </b>
                                        </div>

                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div ref="container" v-show="check == false && checkTemplate == false" class="mt-5 " style="padding-bottom: 10px;">
                        <div class="d-flex flex-wrap gap-5 justify-content-around " style=" width: 100%">
                            <div class="relative" style="position: relative; transform:scale(1.2)">
                                <p ref="first_name" style="position: absolute; user-select: none;">{{ userInfo.first_name }}
                                </p>
                                <p ref="middle_name" style="position: absolute; user-select: none;">{{ userInfo.middle_name
                                }}</p>
                                <p ref="last_name" style="position: absolute; user-select: none;">{{ userInfo.last_name }}
                                </p>
                                <p ref="student_number" style="position: absolute; user-select: none;">{{
                                    userInfo.student_no }}</p>
                                <p ref="course" style="position: absolute;  user-select: none;">{{ userInfo.course }}</p>

                                <img ref="profile" :src="profileImages"
                                    style="position: absolute;object-fit: cover; object-position: top; user-select: none;width:115px;height:135px;"
                                    alt="">

                                <img v-if="!!activeTemplate" :src="`/storage/template/${activeTemplate.front}`"
                                    style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                            </div>
                            <div class="relative" style="position: relative;transform:scale(1.2)">
                                <p ref="year_sem" style="position: absolute;  user-select: none;"
                                    v-if="userInfo.school_year_semester">{{ userInfo.school_year_semester.split('/')[1] + ' AY '+ userInfo.school_year_semester.split(' / ')[0] }}</p>


                                <p ref="contact_form" style="position: absolute;  user-select: none;">{{ userInfo.guardian_name }}</p>

                                <p ref="address"
                                    style="position: absolute;line-height: 90%;  user-select: none;text-align: center;">
                                    {{ userInfo.guardian_address }}</p>

                                <p ref="number" style="position: absolute;  user-select: none;">{{ userInfo.contact_no }}
                                </p>
                                <img ref="signature" :src="signatureImages"
                                    style="position: absolute; user-select: none; height:39.637481689453125px;width: 44.6624755859375px;" alt="">
                                <img v-if="!!activeTemplate" :src="`/storage/template/${activeTemplate.back}`"
                                    style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
                    <button type="button" class="btn btn-primary" @click="savePositions">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template >

<script setup>
import { ref, reactive, watch, onMounted } from 'vue';
import interact from 'interactjs'
import axios from "axios";
import { useToast } from "vue-toast-notification";
const alert = useToast()
const check = ref(true);
const checkTemplate = ref(true);
const props = defineProps(['userInfo', 'preview'])
const templates = ref([]);
const activeTemplate = ref([]);
const profileImages = ref('');
const signatureImages = ref('');
const fontSizes = ref([8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 36, 48, 72]);
const selectedFont = ref(16);
const fontFamilies = ref([
    'Arial', 'Verdana', 'Times New Roman', 'Courier New', 'Georgia', 'Comic Sans MS',
    'Calibri', 'Century Gothic', 'Monseratt', 'Poppins', 'Arial Narrow', 'Myriad Pro',
    'Hevetica', 'Baskerville', 'Tahoma', 'Garamond', 'Franklin Gothic', 'Futura',
    'Cambria', 'Rockwell', 'Comfortaa', 'Proxima Nova', 'Roboto', 'Lato',
    'Quick Sand', 'Open Sans', 'Ubuntu', ' Avenir', 'News Gothic', 'Merriweather',
    'Frutiger', 'Public Sans', 'Arial Rounded MT Bold', 'Bebas', 'Palatino',
    'Brandon Grotesque', 'Trebuchet MS',

]);
const selectedFontFamily = ref('Arial');
const selected = reactive({
    fs: '',
    ff: '',
    w: '',
    h: '',
    content: 'select content'
});

const selectedItem = ref(null)
// save position
const savePositions = async () => {
    await axios.post('/api/saso/student/template/position', position);
    alert.success('Updated Successfully!', {
        position: 'top-right'
    });
}
const container = ref(null)
const first_name = ref(null);
const middle_name = ref(null);
const last_name = ref(null);
const student_number = ref(null);
const profile = ref(null);
const course = ref(null);
const year_sem = ref(null);
const signature = ref(null);
const contact_form = ref(null);
const address = ref(null);
const number = ref(null);
const position = reactive({
    firstname: { x: 0, y: 0, fw: '', ff: '',b:'' },
    middlename: { x: 0, y: 0, fw: '', ff: '',b:'' },
    lastname: { x: 0, y: 0, fw: '', ff: '',b:'' },
    student_number: { x: 0, y: 0, fw: '', ff: '',b:'' },
    course: { x: 0, y: 0, fw: '', ff: '',b:'' },
    profile: { x: 0, y: 0, w: 0, h: 0 },
    // BACK
    year_sem: { x: 0, y: 0, fw: '', ff: '',b:'' },
    signature: { x: 0, y: 0, w: 0, h: 0 },
    contact_form:  { x: 0, y: 0, fw: '', ff: '',b:'' },
    address:  { x: 0, y: 0, fw: '', ff: '',b:'',w:0 ,h:0},
    number:  { x: 0, y: 0, fw: '', ff: '' ,b:''},
    template_id: ''
})

watch(props, async (v, o) => {
    if (v.preview) {
        selectedItem.value = null;
        await fetch();
        await fetchStudentSasoRecord();
        await firstName_interact()
        await middleName_interact()
        await lastName_interact();
        await student_number_interact()
        await course_interact()
        await year_sem_interact()
        await contact_form_interact()
        await address_interact()
        await number_interact()
        await signature_interact()
        await signature_interact()
        await profile_interact()
    }
})

// get active template
const fetch = async () => {
    const { data } = await axios.get('/api/saso/upload/id/template');
    templates.value = data;
    activeTemplate.value = data.find(value => {
        return value.status == true;
    })
    position.school_year_semester = props.userInfo.school_year_semester;
    position.student_id = props.userInfo.student_no;
    if (!!activeTemplate.value) {
        checkTemplate.value = false;
        await fetchPosition(activeTemplate.value.id);

    } else {
        checkTemplate.value = true;
    }

}

// pick font
const pickFont = (font) => {
    selectedFont.value = font;
}

// pick font family
const pickFontFamily = (family) => {
    selectedFontFamily.value = family
}


// get student Saso record
const fetchStudentSasoRecord = async () => {
    const res = await axios.post('/api/saso/student/details', { school_year_semester: props.userInfo.school_year_semester, student_id: props.userInfo.student_no })

    if (res.status == 200) {
        check.value = false;
        profileImages.value = !!res.data.image ? 'storage/studentImage/' + res.data.image : check.value = true;
        signatureImages.value = !!res.data.signature ? 'storage/signature/' + res.data.signature : check.value = true;;


    } else {
        check.value = true;
        profileImages.value = '/id_image/man.png'
        signatureImages.value = '/id_signatures/sample.png';
    }
}

// fetch template position
const fetchPosition = async (id) => {
    if (activeTemplate.value == null) return;
    const response = await axios.post('/api/saso/student/template/position/get', { school_year_semester: props.userInfo.school_year_semester, student_id: props.userInfo.student_no })
    if (response.status == 200) {
         // firstname
         first_name.value.style.transform = `translate(${response.data.firstname_x}px, ${response.data.firstname_y}px)`;
        position.firstname.x = parseFloat(response.data.firstname_x);
        position.firstname.y = parseFloat(response.data.firstname_y);
        first_name.value.style.fontSize = !!response.data.firstname_fw ? response.data.firstname_fw + 'px' : '';
        position.firstname.fw = response.data.firstname_fw;
        first_name.value.style.fontFamily = response.data.firstname_ff;
        position.firstname.ff = response.data.firstname_ff;
        first_name.value.style.fontWeight = response.data.firstname_b;
        position.firstname.b = response.data.firstname_b;

        // middlename
        middle_name.value.style.transform = `translate(${response.data.middlename_x}px, ${response.data.middlename_y}px)`;
        position.middlename.x = parseFloat(response.data.middlename_x);
        position.middlename.y = parseFloat(response.data.middlename_y);
        middle_name.value.style.fontSize = !!response.data.middlename_fw ? response.data.middlename_fw + 'px' : '';
        position.middlename.fw = response.data.middlename_fw;
        middle_name.value.style.fontFamily = response.data.middlename_ff;
        position.middlename.ff = response.data.middlename_ff;
        middle_name.value.style.fontWeight = response.data.middlename_b;
        position.middlename.b = response.data.middlename_b;

        // lastname
        last_name.value.style.transform = `translate(${response.data.lastname_x}px, ${response.data.lastname_y}px)`;
        position.lastname.x = parseFloat(response.data.lastname_x);
        position.lastname.y = parseFloat(response.data.lastname_y);
        last_name.value.style.fontSize = !!response.data.lastname_fw ? response.data.lastname_fw + 'px' : '';
        position.lastname.fw = response.data.lastname_fw;
        last_name.value.style.fontFamily = response.data.lastname_ff;
        position.lastname.ff = response.data.lastname_ff;
        last_name.value.style.fontWeight = response.data.lastname_b;
        position.lastname.b = response.data.lastname_b;

        // student_number
        student_number.value.style.transform = `translate(${response.data.student_number_x}px, ${response.data.student_number_y}px)`;
        position.student_number.x = parseFloat(response.data.student_number_x);
        position.student_number.y = parseFloat(response.data.student_number_y);
        student_number.value.style.fontSize = !!response.data.student_number_fw ? response.data.student_number_fw + 'px' : '';
        position.student_number.fw = response.data.student_number_fw;
        student_number.value.style.fontFamily = response.data.student_number_ff;
        position.student_number.ff = response.data.student_number_ff;
        student_number.value.style.fontWeight = response.data.student_number_b;
        position.student_number.b = response.data.student_number_b;

        // course
        course.value.style.transform = `translate(${response.data.course_x}px, ${response.data.course_y}px)`;
        position.course.x = parseFloat(response.data.course_x);
        position.course.y = parseFloat(response.data.course_y);
        course.value.style.fontSize = !!response.data.course_fw ? response.data.course_fw + 'px' : '';
        position.course.fw = response.data.course_fw;
        course.value.style.fontFamily = response.data.course_ff;
        position.course.ff = response.data.course_ff;
        course.value.style.fontWeight = response.data.course_b;
        position.course.b = response.data.course_b;

        // year / sem
        year_sem.value.style.transform = `translate(${response.data.year_sem_x}px, ${response.data.year_sem_y}px)`;
        position.year_sem.x = parseFloat(response.data.year_sem_x);
        position.year_sem.y = parseFloat(response.data.year_sem_y);
        year_sem.value.style.fontSize = !!response.data.year_sem_fw ? response.data.year_sem_fw + 'px' : '';
        position.year_sem.fw = response.data.year_sem_fw;
        year_sem.value.style.fontFamily = response.data.year_sem_ff;
        position.year_sem.ff = response.data.year_sem_ff;
        year_sem.value.style.fontWeight = response.data.year_sem_b;
        position.year_sem.b = response.data.year_sem_b;

        // contact_form
        contact_form.value.style.transform = `translate(${response.data.contact_form_x}px, ${response.data.contact_form_y}px)`;
        position.contact_form.x = parseFloat(response.data.contact_form_x);
        position.contact_form.y = parseFloat(response.data.contact_form_y);
        contact_form.value.style.fontSize = !!response.data.contact_form_fw ? response.data.contact_form_fw + 'px' : '';
        position.contact_form.fw = response.data.contact_form_fw;
        contact_form.value.style.fontFamily = response.data.contact_form_ff;
        position.contact_form.ff = response.data.contact_form_ff;
        contact_form.value.style.fontWeight = response.data.contact_form_b;
        position.contact_form.b = response.data.contact_form_b;

        // addresponses
        address.value.style.transform = `translate(${response.data.address_x}px, ${response.data.address_y}px)`;
        position.address.x = parseFloat(response.data.address_x);
        position.address.y = parseFloat(response.data.address_y);
        address.value.style.fontSize = !!response.data.address_fw ? response.data.address_fw + 'px' : '';
        position.address.fw = response.data.address_fw;
        address.value.style.fontFamily = response.data.address_ff;
        position.address.ff = response.data.address_ff;
        address.value.style.fontWeight = response.data.address_b;
        position.address.b = response.data.address_b;


        position.address.w = response.data.address_w;
        position.address.h = response.data.address_h;
        if (response.data.address_w != '0' && response.data.address_h != '0') {
            Object.assign(address.value.style, {
                width: `${response.data.address_w}px`,
                height: `${response.data.address_h}px`,
            })
        }
        // number
        number.value.style.transform = `translate(${response.data.number_x}px, ${response.data.number_y}px)`;
        position.number.x = parseFloat(response.data.number_x);
        position.number.y = parseFloat(response.data.number_y);
        number.value.style.fontSize = !!response.data.number_fw ? response.data.number_fw + 'px' : '';
        position.number.fw = response.data.number_fw;
        number.value.style.fontFamily = response.data.number_ff;
        position.number.ff = response.data.number_ff;
        number.value.style.fontWeight = response.data.number_b;
        position.number.b = response.data.number_b;

        // profile
        profile.value.style.transform = `translate(${response.data.profile_x}px, ${response.data.profile_y}px)`;
        position.profile.x = parseFloat(response.data.profile_x);
        position.profile.y = parseFloat(response.data.profile_y);
        position.profile.w = parseFloat(response.data.profile_w);
        position.profile.h = parseFloat(response.data.profile_h);
        // Object.assign(profile.value.style, {
        //     width: `${response.data.profile_w}px`,
        //     height: `${response.data.profile_h}px`,
        // })

        // signiture
        signature.value.style.transform = `translate(${response.data.signature_x}px, ${response.data.signature_y}px)`;
        position.signature.x = parseFloat(response.data.signature_x);
        position.signature.y = parseFloat(response.data.signature_y);
        position.signature.w = parseFloat(response.data.signature_w);
        position.signature.h = parseFloat(response.data.signature_h);
        if (response.data.signature_w != '0' && response.data.signature_h != '0') {
            Object.assign(signature.value.style, {
                width: `${response.data.signature_w}px`,
                height: `${response.data.signature_h}px`,
            })
        }

    } else {
        const res = await axios.get('/api/saso/template/position/' + id);

        if (res.status == 200) {
            // firstname
        first_name.value.style.transform = `translate(${res.data.firstname_x}px, ${res.data.firstname_y}px)`;
        position.firstname.x = parseFloat(res.data.firstname_x);
        position.firstname.y = parseFloat(res.data.firstname_y);
        first_name.value.style.fontSize = !!res.data.firstname_fw ? res.data.firstname_fw + 'px' : '';
        position.firstname.fw = res.data.firstname_fw;
        first_name.value.style.fontFamily = res.data.firstname_ff;
        position.firstname.ff = res.data.firstname_ff;
        first_name.value.style.fontWeight = res.data.firstname_b;
        position.firstname.b = res.data.firstname_b;

        // middlename
        middle_name.value.style.transform = `translate(${res.data.middlename_x}px, ${res.data.middlename_y}px)`;
        position.middlename.x = parseFloat(res.data.middlename_x);
        position.middlename.y = parseFloat(res.data.middlename_y);
        middle_name.value.style.fontSize = !!res.data.middlename_fw ? res.data.middlename_fw + 'px' : '';
        position.middlename.fw = res.data.middlename_fw;
        middle_name.value.style.fontFamily = res.data.middlename_ff;
        position.middlename.ff = res.data.middlename_ff;
        middle_name.value.style.fontWeight = res.data.middlename_b;
        position.middlename.b = res.data.middlename_b;

        // lastname
        last_name.value.style.transform = `translate(${res.data.lastname_x}px, ${res.data.lastname_y}px)`;
        position.lastname.x = parseFloat(res.data.lastname_x);
        position.lastname.y = parseFloat(res.data.lastname_y);
        last_name.value.style.fontSize = !!res.data.lastname_fw ? res.data.lastname_fw + 'px' : '';
        position.lastname.fw = res.data.lastname_fw;
        last_name.value.style.fontFamily = res.data.lastname_ff;
        position.lastname.ff = res.data.lastname_ff;
        last_name.value.style.fontWeight = res.data.lastname_b;
        position.lastname.b = res.data.lastname_b;

        // student_number
        student_number.value.style.transform = `translate(${res.data.student_number_x}px, ${res.data.student_number_y}px)`;
        position.student_number.x = parseFloat(res.data.student_number_x);
        position.student_number.y = parseFloat(res.data.student_number_y);
        student_number.value.style.fontSize = !!res.data.student_number_fw ? res.data.student_number_fw + 'px' : '';
        position.student_number.fw = res.data.student_number_fw;
        student_number.value.style.fontFamily = res.data.student_number_ff;
        position.student_number.ff = res.data.student_number_ff;
        student_number.value.style.fontWeight = res.data.student_number_b;
        position.student_number.b = res.data.student_number_b;

        // course
        course.value.style.transform = `translate(${res.data.course_x}px, ${res.data.course_y}px)`;
        position.course.x = parseFloat(res.data.course_x);
        position.course.y = parseFloat(res.data.course_y);
        course.value.style.fontSize = !!res.data.course_fw ? res.data.course_fw + 'px' : '';
        position.course.fw = res.data.course_fw;
        course.value.style.fontFamily = res.data.course_ff;
        position.course.ff = res.data.course_ff;
        course.value.style.fontWeight = res.data.course_b;
        position.course.b = res.data.course_b;

        // year / sem
        year_sem.value.style.transform = `translate(${res.data.year_sem_x}px, ${res.data.year_sem_y}px)`;
        position.year_sem.x = parseFloat(res.data.year_sem_x);
        position.year_sem.y = parseFloat(res.data.year_sem_y);
        year_sem.value.style.fontSize = !!res.data.year_sem_fw ? res.data.year_sem_fw + 'px' : '';
        position.year_sem.fw = res.data.year_sem_fw;
        year_sem.value.style.fontFamily = res.data.year_sem_ff;
        position.year_sem.ff = res.data.year_sem_ff;
        year_sem.value.style.fontWeight = res.data.year_sem_b;
        position.year_sem.b = res.data.year_sem_b;

        // contact_form
        contact_form.value.style.transform = `translate(${res.data.contact_form_x}px, ${res.data.contact_form_y}px)`;
        position.contact_form.x = parseFloat(res.data.contact_form_x);
        position.contact_form.y = parseFloat(res.data.contact_form_y);
        contact_form.value.style.fontSize = !!res.data.contact_form_fw ? res.data.contact_form_fw + 'px' : '';
        position.contact_form.fw = res.data.contact_form_fw;
        contact_form.value.style.fontFamily = res.data.contact_form_ff;
        position.contact_form.ff = res.data.contact_form_ff;
        contact_form.value.style.fontWeight = res.data.contact_form_b;
        position.contact_form.b = res.data.contact_form_b;

        // address
        address.value.style.transform = `translate(${res.data.address_x}px, ${res.data.address_y}px)`;
        position.address.x = parseFloat(res.data.address_x);
        position.address.y = parseFloat(res.data.address_y);
        address.value.style.fontSize = !!res.data.address_fw ? res.data.address_fw + 'px' : '';
        position.address.fw = res.data.address_fw;
        address.value.style.fontFamily = res.data.address_ff;
        position.address.ff = res.data.address_ff;
        address.value.style.fontWeight = res.data.address_b;
        position.address.b = res.data.address_b;
        position.address.w = res.data.address_w;
        position.address.h = res.data.address_h;
        if (res.data.address_w != '0' && res.data.address_h != '0') {
            Object.assign(address.value.style, {
                width: `${res.data.address_w}px`,
                height: `${res.data.address_h}px`,
            })
        }
        // number
        number.value.style.transform = `translate(${res.data.number_x}px, ${res.data.number_y}px)`;
        position.number.x = parseFloat(res.data.number_x);
        position.number.y = parseFloat(res.data.number_y);
        number.value.style.fontSize = !!res.data.number_fw ? res.data.number_fw + 'px' : '';
        position.number.fw = res.data.number_fw;
        number.value.style.fontFamily = res.data.number_ff;
        position.number.ff = res.data.number_ff;
        number.value.style.fontWeight = res.data.number_b;
        position.number.b = res.data.number_b;
            // profile
            profile.value.style.transform = `translate(${res.data.profile_x}px, ${res.data.profile_y}px)`;
            position.profile.x = parseFloat(res.data.profile_x);
            position.profile.y = parseFloat(res.data.profile_y);
            position.profile.w = parseFloat(res.data.profile_w);
            position.profile.h = parseFloat(res.data.profile_h);
            // Object.assign(profile.value.style, {
            //     width: `${res.data.profile_w}px`,
            //     height: `${res.data.profile_h}px`,
            // })

            // signiture
            signature.value.style.transform = `translate(${res.data.signature_x}px, ${res.data.signature_y}px)`;
            position.signature.x = parseFloat(res.data.signature_x);
            position.signature.y = parseFloat(res.data.signature_y);
            position.signature.w = parseFloat(res.data.signature_w);
            position.signature.h = parseFloat(res.data.signature_h);
            if (res.data.signature_w != '0' && res.data.signature_h != '0') {
                Object.assign(signature.value.style, {
                    width: `${res.data.signature_w}px`,
                    height: `${res.data.signature_h}px`,
                })
            }


        }
    }

}
const profile_interact = () => {
    const profilev = interact(profile.value);
    profilev.draggable({
        listeners: {
            move(event) {
                position.profile.x += event.dx
                position.profile.y += event.dy

                event.target.style.transform =
                    `translate(${position.profile.x}px, ${position.profile.y}px)`
            },
        }
    })

    profilev.on('doubletap', function (event) {
        selectedItem.value = event.target;


    })

    // profilev.resizable({
    //     edges: { top: true, left: true, bottom: true, right: true },
    //     listeners: {
    //         move: function (event) {

    //             let { x, y } = event.target.dataset


    //             x = (parseFloat(x) || 0) + event.deltaRect.left
    //             y = (parseFloat(y) || 0) + event.deltaRect.top
    //             // localStorage.setItem('imagewidth',event.rect.width)
    //             // localStorage.setItem('imageheight',event.rect.height)
    //             position.profile.w = event.rect.width;
    //             position.profile.h = event.rect.height;

    //             Object.assign(event.target.style, {
    //                 width: `${event.rect.width}px`,
    //                 height: `${event.rect.height}px`,
    //                 // transform: `translate(${x}px, ${y}px)`
    //             })

    //             Object.assign(event.target.dataset, { x, y })

    //         }
    //     }
    // })
}
const firstName_interact = () => {
    const firstnamev = interact(first_name.value);
    firstnamev.draggable({
        listeners: {
            move(event) {
                position.firstname.x += event.dx
                position.firstname.y += event.dy

                event.target.style.transform =
                    `translate(${position.firstname.x}px, ${position.firstname.y}px)`
            },
        }
    })
    firstnamev.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.firstname.fw = selectedFont.value;

        selected.fw = position.firstname.fw;
        selected.ff = position.firstname.ff;
        selected.content = 'First name';
        selectedItem.value = event.target;
    })

}

const middleName_interact = () => {
    const middlenamev = interact(middle_name.value);
    middlenamev.draggable({
        listeners: {
            move(event) {
                position.middlename.x += event.dx
                position.middlename.y += event.dy
                event.target.style.transform =
                    `translate(${position.middlename.x}px, ${position.middlename.y}px)`
            },
        }
    })
    middlenamev.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.middlename.fw = selectedFont.value;

        selected.fw = position.middlename.fw;
        selected.ff = position.middlename.ff;
        selected.content = 'Middle name';
        selectedItem.value = event.target;

    })


}

const lastName_interact = () => {
    const lastnamev = interact(last_name.value);
    lastnamev.draggable({
        listeners: {
            move(event) {
                position.lastname.x += event.dx
                position.lastname.y += event.dy
                event.target.style.transform =
                    `translate(${position.lastname.x}px, ${position.lastname.y}px)`
            },
        }
    })

    lastnamev.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.lastname.fw = selectedFont.value;

        selected.fw = position.lastname.fw;
        selected.ff = position.lastname.ff;
        selected.content = 'Last name';
        selectedItem.value = event.target;
    })

}

const student_number_interact = () => {
    const student_numberv = interact(student_number.value);
    student_numberv.draggable({
        listeners: {

            move(event) {
                position.student_number.x += event.dx
                position.student_number.y += event.dy

                event.target.style.transform =
                    `translate(${position.student_number.x}px, ${position.student_number.y}px)`
            },
        }
    })
    student_numberv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.student_number.fw = selectedFont.value;

        selected.fw = position.student_number.fw;
        selected.ff = position.student_number.ff;
        selected.content = 'Student Number';
        selectedItem.value = event.target;
    })

}

const course_interact = () => {
    const coursev = interact(course.value);
    coursev.draggable({
        listeners: {

            move(event) {
                position.course.x += event.dx
                position.course.y += event.dy

                event.target.style.transform =
                    `translate(${position.course.x}px, ${position.course.y}px)`
            },
        }
    })
    coursev.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.course.fw = selectedFont.value;

        selected.fw = position.course.fw;
        selected.ff = position.course.ff;
        selected.content = 'Course';
        selectedItem.value = event.target;

    })

}
const year_sem_interact = () => {
    const yearsemv = interact(year_sem.value);
    yearsemv.draggable({
        listeners: {

            move(event) {
                position.year_sem.x += event.dx
                position.year_sem.y += event.dy

                event.target.style.transform =
                    `translate(${position.year_sem.x}px, ${position.year_sem.y}px)`
            },
        }
    })
    yearsemv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.year_sem.fw = selectedFont.value;

        selected.fw = position.year_sem.fw;
        selected.ff = position.year_sem.ff;
        selected.content = 'School year & semester';
        selectedItem.value = event.target;
    })

}
const contact_form_interact = () => {
    const contact_formv = interact(contact_form.value);
    contact_formv.draggable({
        listeners: {

            move(event) {
                position.contact_form.x += event.dx
                position.contact_form.y += event.dy

                event.target.style.transform =
                    `translate(${position.contact_form.x}px, ${position.contact_form.y}px)`
            },
        }
    })
    contact_formv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.contact_form.fw = selectedFont.value;

        selected.fw = position.contact_form.fw;
        selected.ff = position.contact_form.ff;
        selected.content = 'Guardian Name';
        selectedItem.value = event.target;
    })

}
const address_interact = () => {
    const addressv = interact(address.value);
    addressv.draggable({
        listeners: {

            move(event) {
                position.address.x += event.dx
                position.address.y += event.dy

                event.target.style.transform =
                    `translate(${position.address.x}px, ${position.address.y}px)`
            },
        }
    })
    addressv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.address.fw = selectedFont.value;

        selected.fw = position.address.fw;
        selected.ff = position.address.ff;
        selected.content = 'Address';
        selectedItem.value = event.target;
    })

    addressv.resizable({
        edges: { top: false, left: false, bottom: false, right: true },
        invert: 'reposition',
        listeners: {
            move: function (event) {

                let { x, y } = event.target.dataset


                x = (parseFloat(x) || 0) + event.deltaRect.left
                y = (parseFloat(y) || 0) + event.deltaRect.top

                position.address.w = event.rect.width;
                position.address.h = event.rect.height;
                Object.assign(event.target.style, {
                    width: `${event.rect.width}px`,
                    height: `${event.rect.height}px`,
                    // transform: `translate(${x}px, ${y}px)`
                })

                Object.assign(event.target.dataset, { x, y })

            }
        }
    })

}
const number_interact = () => {
    const numberv = interact(number.value);
    numberv.draggable({
        listeners: {

            move(event) {
                position.number.x += event.dx
                position.number.y += event.dy

                event.target.style.transform =
                    `translate(${position.number.x}px, ${position.number.y}px)`
            },
        }
    })
    numberv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.number.fw = selectedFont.value;

        selected.fw = position.number.fw;
        selected.ff = position.number.ff;
        selected.content = 'Phone number';
        selectedItem.value = event.target;
    })


}

const signature_interact = () => {
    const signaturev = interact(signature.value);
    signaturev.draggable({

        listeners: {

            move(event) {
                position.signature.x += event.dx
                position.signature.y += event.dy

                event.target.style.transform =
                    `translate(${position.signature.x}px, ${position.signature.y}px)`
            },
        }
    })
    signaturev.on('doubletap', function (event) {
        selectedItem.value = event.target;


    })
    signaturev.resizable({
        edges: { top: true, left: true, bottom: false, right: false },
        invert: 'reposition',
        listeners: {
            move: function (event) {

                let { x, y } = event.target.dataset


                x = (parseFloat(x) || 0) + event.deltaRect.left
                y = (parseFloat(y) || 0) + event.deltaRect.top

                position.signature.w = event.rect.width;
                position.signature.h = event.rect.height;
                Object.assign(event.target.style, {
                    width: `${event.rect.width}px`,
                    height: `${event.rect.height}px`,
                    // transform: `translate(${x}px, ${y}px)`
                })

                Object.assign(event.target.dataset, { x, y })

            }
        }
    })
}
watch(selectedItem,(v,o) => {

    if(v != null)
    {
        if(!!v.src)
    {

        v.style.border = '1px solid red';

        !!o ? o.style.color = 'black' : ''
    }else{
        !!o ? o.style.border = 'none' : '';

        !!o ? o.style.color = '#212529' : ''

        v.style.color = 'green'
    }
    }else{
        if(!!o.src)
    {

        !!o ? o.style.border = 'none' : '';

        !!o ? o.style.color = '#212529' : ''
    }else{
        !!o ? o.style.border = 'none' : '';

        !!o ? o.style.color = '#212529' : ''

    }
    }
})
onMounted(() =>{
    document.addEventListener('click', function(event) {

  if (!container.value.contains(event.target)) {

    selectedItem.value = null;
  }
});
})
</script>
