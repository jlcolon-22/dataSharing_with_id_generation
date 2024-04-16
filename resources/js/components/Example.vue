<template>
    <main class="p-5" style="overflow-y: auto;min-height: calc(100vh - 80px);max-height: calc(100vh - 80px);">
        <div class="card" style="width: 500px">
            <div class="card-header">
                Upload ID Template
            </div>
            <div class="card-body">
                <form @submit.prevent="store">

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Front</label>
                        <input ref="frontFile" type="file" @change="uploadFront" required class="form-control" id="remarks">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Back</label>
                        <input ref="backFile" type="file" required @change="uploadBack" class="form-control" id="amount">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>


        <div class="card mt-5">
            <div class="card-header">
                Templates
            </div>
            <div class="card-body" style="display: grid;grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; max-height: 400px; overflow-y:auto">
                <div v-if="templates.length == 0" class="alert alert-info">
                    <strong>No Available Template</strong>
                </div>
                <div style="position: relative;" v-for="template in templates" :key="template">
                    <div v-if="template.status"
                        style="position: absolute; background: #0009; width: 400px; height: 100%;display: flex;justify-content: center; align-items: center;">
                        <h1 class="text-white" style="font-weight: bolder;">Active</h1>
                    </div>
                    <a type="button" @click="active(template.id)"><img :src="`/storage/template/${template.front}`"
                            style="width: 400px;" loading="lazy" alt=""></a>
                </div>
            </div>
        </div>

        <div v-if="!!activeTemplate" class="card mt-5">
            <div class="card-header">
                Edit Templates
            </div>
            <div class="card-body " style="padding: 10px 10px 10px 10px;">
                <!-- toolbar -->
                <div class="d-flex justify-content-between p-6">
                    <div class="d-flex gap-2 col-md-4  rounded" style="padding-bottom: 20px;">
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
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle" type="button" id="dropdownFamily"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Font Family ({{ selectedFontFamily }})
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownFamily"
                                style="max-height: 300px; overflow-y: auto;">
                                <li v-for="family in fontFamilies" :key="family"><button @click="pickFontFamily(family)"
                                        class="dropdown-item" type="button">{{ family }}</button></li>

                            </ul>
                        </div>

                    </div>
                    <div class="col-md-6 border rounded d-flex">
                        <!-- For font family dropdown -->
                        <div class="container mt-3 mx-auto  gap-3" style="display: grid;grid-template-columns: repeat(2, minmax(0, 1fr));">
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
                            <section class="d-flex align-items-center" style="flex-grow: 1;">

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
                <form @submit.prevent="savePositions" class="mt-5">
                    <div ref="container" class="d-grid gap-5" style="margin: 0 auto; width: fit-content;">
                        <div class="relative" style="position: relative; transform:scale(1.2)">
                            <p ref="first_name" style="position: absolute; user-select: none;">Johnloyd</p>
                            <p ref="middle_name" style="position: absolute; user-select: none;">Marcos</p>
                            <p ref="last_name" style="position: absolute; user-select: none;">Cruz</p>
                            <p ref="student_number" style="position: absolute; user-select: none;">20-1234</p>
                            <p ref="course" style="position: absolute;  user-select: none;">BS. INFORMATION TECHNOLOGY</p>

                            <img ref="profile" src="/id_image/23-002.png"
                                style="position: absolute;object-fit: cover; object-position: center; user-select: none;width:115px;height:135px;"
                                alt="">

                            <img v-if="!!activeTemplate" :src="`/storage/template/${activeTemplate.front}`"
                                style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                        </div>
                        <div class="relative" style="position: relative;transform:scale(1.2)">
                            <p ref="year_sem" style="position: absolute;  user-select: none;">2nd Semester AY 2023 - 2024
                            </p>

                            <p ref="contact_form" style="position: absolute;  user-select: none;">Jane Cruz</p>

                            <p ref="address" style="position: absolute;line-height: 90%;  user-select: none;max-width: 130px;text-align: center;">Barangay Malakas, Manila City</p>

                            <p ref="number" style="position: absolute;  user-select: none;">09101012341</p>
                            <img ref="signature" src="/id_signatures/sample.png"
                                style="position: absolute; user-select: none;height: 39.637481689453125px;width: 44.6624755859375px;" alt="">
                            <img v-if="!!activeTemplate" :src="`/storage/template/${activeTemplate.back}`"
                                style="hheight: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                        </div>
                    </div>
                   <div style="margin-top: 100px;">
                    <button type="submit" class="btn btn-success mt-3 float-end" style="width: 150px;">Save
                        Template</button>
                   </div>
                </form>
            </div>
        </div>
    </main>
</template>
<script setup>
import { onBeforeMount, onMounted, reactive, ref, watch } from "vue";
import interact from 'interactjs'
import axios from "axios";
import { useToast } from "vue-toast-notification";
const alert = useToast();
const state = reactive({
    front: '',
    back: ''
});
const templates = ref([]);
const activeTemplate = ref([]);
const fontSizes = ref([8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 36, 48, 72]);
const selectedFont = ref(16);
const fontFamilies = ref([
    'Arial', 'Verdana', 'Times New Roman', 'Courier New', 'Georgia', 'Comic Sans MS',
    'Calibri', 'Century Gothic', 'Montserrat', 'Poppins', 'Arial Narrow', 'Myriad Pro',
    'Hevetica', 'Baskerville', 'Tahoma', 'Garamond', 'Franklin Gothic', 'Futura',
    'Cambria', 'Rockwell', 'Comfortaa', 'Proxima Nova', 'Roboto', 'Lato',
    'Quick Sand', 'Open Sans', 'Ubuntu', ' Avenir', 'News Gothic', 'Merriweather',
    'Frutiger', 'Public Sans', 'Arial Rounded MT Bold', 'Bebas', 'Palatino',
    'Brandon Grotesque', 'Trebuchet MS',

]);

const frontFile = ref(null);
const backFile = ref(null);
const selectedFontFamily = ref('Arial');
const selected = reactive({
    fs: '',
    ff: '',
    w: '',
    h: '',
    content: 'select content'
});

const container = ref(null);
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

const selectedItem = ref(null);

const position = reactive({
    firstname: { x: 0, y: 0, fw: '', ff: '' },
    middlename: { x: 0, y: 0, fw: '', ff: '' },
    lastname: { x: 0, y: 0, fw: '', ff: '' },
    student_number: { x: 0, y: 0, fw: '', ff: '' },
    course: { x: 0, y: 0, fw: '', ff: '' },
    profile: { x: 0, y: 0, w: 0, h: 0 },
    // BACK
    year_sem: { x: 0, y: 0, fw: '', ff: '' },
    signature: { x: 0, y: 0, w: 0, h: 0 },
    contact_form:  { x: 0, y: 0, fw: '', ff: '' },
    address:  { x: 0, y: 0, fw: '', ff: '' },
    number:  { x: 0, y: 0, fw: '', ff: '' },
    template_id: ''
})

const uploadFront = (e) => {
    state.front = e.target.files[0];
}
const uploadBack = (e) => {
    state.back = e.target.files[0];
}

// upload id template
const store = async () => {
    let formData = new FormData();
    formData.append('front', state.front);
    formData.append('back', state.back);
    const res = await axios.post('/api/saso/upload/id/template', formData)
    frontFile.value.value = '';
    backFile.value.value = '';
    alert.success('Uploaded Successfully!', {
        position: 'top-right'
    });
    await fetch()
}

// fetch template
const fetch = async () => {
    const { data } = await axios.get('/api/saso/upload/id/template');
    templates.value = data;
    activeTemplate.value = data.find(value => {
        return value.status == true;
    })
    position.template_id = activeTemplate.value.id;
    await fetchPosition(activeTemplate.value.id);
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
    await profile_interact()

}
// fetch template position
const fetchPosition = async (id) => {
    if (activeTemplate.value == null) return;
    const res = await axios.get('/api/saso/template/position/' + id);
    console.log(res.data)
    if (res.status == 200) {
        // firstname
        first_name.value.style.transform = `translate(${res.data.firstname_x}px, ${res.data.firstname_y}px)`;
        position.firstname.x = parseFloat(res.data.firstname_x);
        position.firstname.y = parseFloat(res.data.firstname_y);
        first_name.value.style.fontSize = !!res.data.firstname_fw ? res.data.firstname_fw + 'px' : '';
        position.firstname.fw = res.data.firstname_fw;
        first_name.value.style.fontFamily = res.data.firstname_ff;
        position.firstname.ff = res.data.firstname_ff;

        // middlename
        middle_name.value.style.transform = `translate(${res.data.middlename_x}px, ${res.data.middlename_y}px)`;
        position.middlename.x = parseFloat(res.data.middlename_x);
        position.middlename.y = parseFloat(res.data.middlename_y);
        middle_name.value.style.fontSize = !!res.data.middlename_fw ? res.data.middlename_fw + 'px' : '';
        position.middlename.fw = res.data.middlename_fw;
        middle_name.value.style.fontFamily = res.data.middlename_ff;
        position.middlename.ff = res.data.middlename_ff;

        // lastname
        last_name.value.style.transform = `translate(${res.data.lastname_x}px, ${res.data.lastname_y}px)`;
        position.lastname.x = parseFloat(res.data.lastname_x);
        position.lastname.y = parseFloat(res.data.lastname_y);
        last_name.value.style.fontSize = !!res.data.lastname_fw ? res.data.lastname_fw + 'px' : '';
        position.lastname.fw = res.data.lastname_fw;
        last_name.value.style.fontFamily = res.data.lastname_ff;
        position.lastname.ff = res.data.lastname_ff;

        // student_number
        student_number.value.style.transform = `translate(${res.data.student_number_x}px, ${res.data.student_number_y}px)`;
        position.student_number.x = parseFloat(res.data.student_number_x);
        position.student_number.y = parseFloat(res.data.student_number_y);
        student_number.value.style.fontSize = !!res.data.student_number_fw ? res.data.student_number_fw + 'px' : '';
        position.student_number.fw = res.data.student_number_fw;
        student_number.value.style.fontFamily = res.data.student_number_ff;
        position.student_number.ff = res.data.student_number_ff;

        // course
        course.value.style.transform = `translate(${res.data.course_x}px, ${res.data.course_y}px)`;
        position.course.x = parseFloat(res.data.course_x);
        position.course.y = parseFloat(res.data.course_y);
        course.value.style.fontSize = !!res.data.course_fw ? res.data.course_fw + 'px' : '';
        position.course.fw = res.data.course_fw;
        course.value.style.fontFamily = res.data.course_ff;
        position.course.ff = res.data.course_ff;

        // year / sem
        year_sem.value.style.transform = `translate(${res.data.year_sem_x}px, ${res.data.year_sem_y}px)`;
        position.year_sem.x = parseFloat(res.data.year_sem_x);
        position.year_sem.y = parseFloat(res.data.year_sem_y);
        year_sem.value.style.fontSize = !!res.data.year_sem_fw ? res.data.year_sem_fw + 'px' : '';
        position.year_sem.fw = res.data.year_sem_fw;
        year_sem.value.style.fontFamily = res.data.year_sem_ff;
        position.year_sem.ff = res.data.year_sem_ff;
        // contact_form
        contact_form.value.style.transform = `translate(${res.data.contact_form_x}px, ${res.data.contact_form_y}px)`;
        position.contact_form.x = parseFloat(res.data.contact_form_x);
        position.contact_form.y = parseFloat(res.data.contact_form_y);
        contact_form.value.style.fontSize = !!res.data.contact_form_fw ? res.data.contact_form_fw + 'px' : '';
        position.contact_form.fw = res.data.contact_form_fw;
        contact_form.value.style.fontFamily = res.data.contact_form_ff;
        position.contact_form.ff = res.data.contact_form_ff;
        // address
        address.value.style.transform = `translate(${res.data.address_x}px, ${res.data.address_y}px)`;
        position.address.x = parseFloat(res.data.address_x);
        position.address.y = parseFloat(res.data.address_y);
        address.value.style.fontSize = !!res.data.address_fw ? res.data.address_fw + 'px' : '';
        position.address.fw = res.data.address_fw;
        address.value.style.fontFamily = res.data.address_ff;
        position.address.ff = res.data.address_ff;
        // number
        number.value.style.transform = `translate(${res.data.number_x}px, ${res.data.number_y}px)`;
        position.number.x = parseFloat(res.data.number_x);
        position.number.y = parseFloat(res.data.number_y);
        number.value.style.fontSize = !!res.data.number_fw ? res.data.number_fw + 'px' : '';
        position.number.fw = res.data.number_fw;
        number.value.style.fontFamily = res.data.number_ff;
        position.number.ff = res.data.number_ff;

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


    } else {
        first_name.value.style.transform = `translate(-100px, 30px)`;
        position.firstname.x = parseFloat(-100);
        position.firstname.y = parseFloat(30);
        middle_name.value.style.transform = `translate(-100px, 50px)`;
        position.middlename.x = parseFloat(-100);
        position.middlename.y = parseFloat(50);
        last_name.value.style.transform = `translate(-100px, 70px)`;
        position.lastname.x = parseFloat(-100);
        position.lastname.y = parseFloat(70);
        student_number.value.style.transform = `translate(-100px, 90px)`;
        position.student_number.x = parseFloat(-100);
        position.student_number.y = parseFloat(90);
        course.value.style.transform = `translate(-250px, 110px)`;
        position.course.x = parseFloat(-250);
        position.course.y = parseFloat(110);
        profile.value.style.transform = `translate(-200px, 140px)`;
        position.profile.x = parseFloat(-250);
        position.profile.y = parseFloat(140);
        year_sem.value.style.transform = `translate(-200px, 70px)`;
        position.year_sem.x = parseFloat(-200);
        position.year_sem.y = parseFloat(70);
        contact_form.value.style.transform = `translate(-200px, 90px)`;
        position.contact_form.x = parseFloat(-200);
        position.contact_form.y = parseFloat(90);
        address.value.style.transform = `translate(-200px, 110px)`;
        position.address.x = parseFloat(-200);
        position.address.y = parseFloat(110);
        number.value.style.transform = `translate(-200px, 150px)`;
        position.number.x = parseFloat(-200);
        position.number.y = parseFloat(150);
        signature.value.style.transform = `translate(-200px, 160px)`;
        position.signature.x = parseFloat(-200);
        position.signature.y = parseFloat(160);

    }
}

// select template
const active = async (id) => {
    await axios.put('/api/saso/upload/id/template/' + id);
    await fetch()
}

// save template position
const savePositions = async () => {
    await axios.post('/api/saso/template/position', position);
    alert.success('Updated Successfully!', {
        position: 'top-right'
    });
}

// pick font
const pickFont = (font) => {
    selectedFont.value = font;
}

// pick font family
const pickFontFamily = (family) => {
    selectedFontFamily.value = family
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
        event.target.style.fontFamily = selectedFontFamily.value;
        position.firstname.ff = selectedFontFamily.value;
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
        event.target.style.fontFamily = selectedFontFamily.value;
        position.middlename.ff = selectedFontFamily.value;
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
        event.target.style.fontFamily = selectedFontFamily.value;
        position.lastname.ff = selectedFontFamily.value;
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
        event.target.style.fontFamily = selectedFontFamily.value;
        position.student_number.ff = selectedFontFamily.value;
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
        event.target.style.fontFamily = selectedFontFamily.value;
        position.course.ff = selectedFontFamily.value;
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
            start(event) {
                //   console.log(event.type, event.target)
                console.log(event.dx)
            },
            move(event) {
                position.year_sem.x += event.dx
                position.year_sem.y += event.dy
                // console.log(position.x)
                // localStorage.setItem('x', position.x);
                // localStorage.setItem('y', position.y);
                // event.target.style.fontSize = '90px'
                event.target.style.transform =
                    `translate(${position.year_sem.x}px, ${position.year_sem.y}px)`
            },
        }
    })
    yearsemv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.year_sem.fw = selectedFont.value;
        event.target.style.fontFamily = selectedFontFamily.value;
        position.year_sem.ff = selectedFontFamily.value;
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
            start(event) {
                //   console.log(event.type, event.target)
                console.log(event.dx)
            },
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
        event.target.style.fontFamily = selectedFontFamily.value;
        position.contact_form.ff = selectedFontFamily.value;
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
            start(event) {
                //   console.log(event.type, event.target)
                console.log(event.dx)
            },
            move(event) {
                position.address.x += event.dx
                position.address.y += event.dy
                // console.log(position.x)
                // localStorage.setItem('x', position.x);
                // localStorage.setItem('y', position.y);
                // event.target.style.fontSize = '90px'
                event.target.style.transform =
                    `translate(${position.address.x}px, ${position.address.y}px)`
            },
        }
    })
    addressv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.address.fw = selectedFont.value;
        event.target.style.fontFamily = selectedFontFamily.value;
        position.address.ff = selectedFontFamily.value;
        selected.fw = position.address.fw;
        selected.ff = position.address.ff;
        selected.content = 'Address';
        selectedItem.value = event.target;
    })

}
const number_interact = () => {
    const numberv = interact(number.value);
    numberv.draggable({
        listeners: {
            start(event) {
                //   console.log(event.type, event.target)
                console.log(event.dx)
            },
            move(event) {
                position.number.x += event.dx
                position.number.y += event.dy
                // console.log(position.x)
                // localStorage.setItem('x', position.x);
                // localStorage.setItem('y', position.y);
                // event.target.style.fontSize = '90px'
                event.target.style.transform =
                    `translate(${position.number.x}px, ${position.number.y}px)`
            },
        }
    })
    numberv.on('doubletap', function (event) {
        event.target.style.fontSize = selectedFont.value + 'px'
        position.number.fw = selectedFont.value;
        event.target.style.fontFamily = selectedFontFamily.value;
        position.number.ff = selectedFontFamily.value;
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
    console.log(v)
    if(v != null)
    {
        if(!!v.src)
    {

        v.style.border = '1px solid red';
        !!o ? o.style.fontWeight = 'normal' : ''
        !!o ? o.style.color = 'black' : ''
    }else{
        !!o ? o.style.border = 'none' : '';
        !!o ? o.style.fontWeight = 'normal' : ''
        !!o ? o.style.color = '#212529' : ''
        v.style.fontWeight = 'bold'
        v.style.color = 'green'
    }
    }else{
        if(!!o.src)
    {

        !!o ? o.style.border = 'none' : '';
        !!o ? o.style.fontWeight = 'normal' : ''
        !!o ? o.style.color = '#212529' : ''
    }else{
        !!o ? o.style.border = 'none' : '';
        !!o ? o.style.fontWeight = 'normal' : ''
        !!o ? o.style.color = '#212529' : ''

    }
    }
})
onBeforeMount(async () => {
    await fetch();
})
onMounted(async () => {


    document.addEventListener('click', function(event) {
  // Get a reference to the div element


  // Check if the clicked element is myDiv or a child of myDiv
  if (!container.value.contains(event.target)) {
    // The click is outside the div
    selectedItem.value = null;
  }
});

})
</script>
