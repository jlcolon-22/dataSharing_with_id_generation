<template>
    <!-- bulk modal -->
    <div class="modal fade" id="bulkPreviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Generate ID
                    </h5>
                    <button type="button" class="btn-close" @click="$emit('close');removes()" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px;overflow-y: auto;overflow-x: hidden; ">
                    <div v-show="checkTemplate == true" class="alert alert-warning">
                        <strong>No Available Template!</strong>
                    </div>
                    <div v-show="checkImage == true" class="alert alert-warning">
                        <strong>There is a student who does not have an image or signature.</strong>
                    </div>
                    <div v-if="checkTemplate == false && checkImage == false" id="xxx" class="row d-grid">
                        <!-- <div class="col-md-12 d-flex gap-4 flex-wrap border p-2">
                            <img src="/id_template/collegef.png" :key="statePath" style="height:332px; border:none; margin:0; padding:0; overflow:hidden;" />
                            <img src="/id_template/collegeb.png" :key="statePath" style="height:332px; border:none; margin:0; padding:0; overflow:hidden;" />

                        </div> -->
                        <section v-for="value in x" :key="value">
                            <div v-html="value">

                            </div>
                        </section>


                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" v-print="printObject">Print</button>
                    <button type="button" class="btn btn-primary" @click="exportToPDF">Export Pdf</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>
<script setup>
import axios from 'axios';
import { ref, computed, reactive, toRef, watch ,onBeforeUnmount, onMounted} from 'vue';
import { useRouter } from 'vue-router'
import html2pdf from 'html2pdf.js';
const printObject = ref({
    id: 'xxx',
    extraCss: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    popTitle: 'Saso Generate ID',
    async closeCallback (vue) {
        const res = await axios.put('/api/saso/update/status',{data: newProps.value});
    }
})
function exportToPDF() {
    html2pdf(document.getElementById('xxx'), {
        filename: 'myFilename.pdf',
        image: { type: 'png', quality: 1 },
        html2canvas: { scale: 2 },

    });
}
const removes = () =>{
    x.value = [];

}
const checkTemplate = ref(true)
const checkImage = ref(true)
const props = defineProps(['ids', 'bulkPreviewModal']);
const newProps = toRef(props, 'ids');
const x = ref([]);
const activeTemplate = ref([]);

watch(props, async (v, o) => {
    if (v.bulkPreviewModal) {
        await fetch();

    }
})

// active template
const fetch = async () => {
    const { data } = await axios.get('/api/saso/upload/id/template');
    activeTemplate.value = data.find(value => {
        return value.status == true;
    })
    if (!!activeTemplate.value) {
        checkTemplate.value = false;
        await fetchStudentDetails(activeTemplate.value.id);

    } else {
        checkTemplate.value = true;
    }

}
const findtUserInfo = async (id, sys) => {
    const { data } = await axios.get('http://127.0.0.1:8000/newjson/on_process.json');

    const userInfo = data.data.find(value => {
        return value.student_no == id && value.school_year_semester == sys;
    })

    return userInfo;
}
const fetchStudentDetails = async (id) => {
    const response = await axios.post('/api/saso/fetch_student_details', { ids: newProps.value });

    if (!!response.data[0]) {
        response.data.forEach(async element => {
            console.log(element)
            if(element == null)
            {
                x.value = [];
                checkImage.value = true;
                return;
            }
            if(element.image == null || element.signature == null )
            {
                x.value = [];
                checkImage.value = true;
                return;
            }
            checkImage.value = false;
            if (element.student_position[0]) {
                const userInfo = await findtUserInfo(element.student_id, element.school_year_semester);
                x.value.push(`
    <div class="d-flex    py-2 gap-2"  >
                <div class="relative" style="position: relative; ">
                    <p ref="first_name" style="font-size:${element.student_position[0].firstname_fw}px ;font-family: ${element.student_position[0].firstname_ff}; position: absolute; user-select: none; transform: translate(${element.student_position[0].firstname_x}px,${element.student_position[0].firstname_y}px)">${userInfo.first_name}</p>
                    <p ref="middle_name" style="font-size:${element.student_position[0].middlename_fw}px ;font-family: ${element.student_position[0].middlename_ff};position: absolute; user-select: none;transform: translate(${element.student_position[0].middlename_x}px,${element.student_position[0].middlename_y}px)">${userInfo.middle_name}</p>
                    <p ref="last_name" style="font-size:${element.student_position[0].lastname_fw}px ;font-family: ${element.student_position[0].lastname_ff}; position: absolute; user-select: none;transform: translate(${element.student_position[0].lastname_x}px,${element.student_position[0].lastname_y}px)">${userInfo.last_name}</p>
                    <p ref="student_number" style="font-size:${element.student_position[0].student_number_fw}px ;font-family: ${element.student_position[0].student_number_ff}; position: absolute; user-select: none;transform: translate(${element.student_position[0].student_number_x}px,${element.student_position[0].student_number_y}px)">${userInfo.student_no}</p>
                    <p ref="course" style="font-size:${element.student_position[0].course_fw}px ;font-family: ${element.student_position[0].course_ff}; position: absolute;  user-select: none;transform: translate(${element.student_position[0].course_x}px,${element.student_position[0].course_y}px)">${userInfo.course}</p>

                    <img ref="profile" src="storage/studentImage/${element.image}"
                        style="position: absolute;object-fit: cover; object-position: top; user-select: none;width:115px;height:135px; transform: translate(${element.student_position[0].profile_x}px,${element.student_position[0].profile_y}px)" alt="">

                    <img  src="storage/template/${activeTemplate.value.front}" style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                </div>
                <div class="relative" style="position: relative;">

                    <p ref="year_sem" style="font-size:${element.student_position[0].year_sem_fw}px ;font-family: ${element.student_position[0].year_sem_ff};position: absolute;  user-select: none;transform: translate(${element.student_position[0].year_sem_x}px,${element.student_position[0].year_sem_y}px)">${userInfo.school_year_semester.split('/')[1]} 'AY' ${userInfo.school_year_semester.split('/')[0]}</p>

                    <p ref="contact_form" style="font-size:${element.student_position[0].contact_form_fw}px ;font-family: ${element.student_position[0].contact_form_ff};transform: translate(${element.student_position[0].contact_form_x}px,${element.student_position[0].contact_form_y}px);position: absolute;  user-select: none;">${userInfo.guardian_name}</p>

                    <p ref="address" style="line-height: 90%;font-size:${element.student_position[0].address_fw}px ;font-family: ${element.student_position[0].address_ff};transform: translate(${element.student_position[0].address_x}px,${element.student_position[0].address_y}px);position: absolute;  user-select: none;max-width: 130px;text-align: center;"">${userInfo.guardian_address}</p>

                    <p ref="number" style="font-size:${element.student_position[0].number_fw}px ;font-family: ${element.student_position[0].number_ff};transform: translate(${element.student_position[0].number_x}px,${element.student_position[0].number_y}px);position: absolute;  user-select: none;">${userInfo.contact_no}</p>
                    <img ref="signature" src="storage/signature/${element.signature}" style="position: absolute; user-select: none; transform: translate(${element.student_position[0].signature_x}px,${element.student_position[0].signature_y}px);${element.student_position[0].signature_w > 0 ? "width:"+element.student_position[0].signature_w+"px;" : 'width: 44.6624755859375px;'}${element.student_position[0].signature_h > 0 ? "height:"+element.student_position[0].signature_h+"px;" : ' height:39.637481689453125px;"'}"  alt="">
                    <img  src="storage/template/${activeTemplate.value.back}" style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                </div>
            </div>
    `)
            } else {
                const userInfo = await findtUserInfo(element.student_id, element.school_year_semester);
                const res = await axios.get('/api/saso/template/position/' + id);

                if (res.status == 200) {
                    x.value.push(`
    <div class="d-flex  py-2 gap-2"  >
                <div class="relative" style="position: relative; ">
                    <p ref="first_name" style="font-size:${res.data.firstname_fw}px ;font-family: ${res.data.firstname_ff};position: absolute; user-select: none; transform: translate(${res.data.firstname_x}px,${res.data.firstname_y}px)">${userInfo.first_name}</p>
                    <p ref="middle_name" style="font-size:${res.data.middlename_fw}px ;font-family: ${res.data.middlename_ff};position: absolute; user-select: none;transform: translate(${res.data.middlename_x}px,${res.data.middlename_y}px)">${userInfo.middle_name}</p>
                    <p ref="last_name" style="font-size:${res.data.lastname_fw}px ;font-family: ${res.data.lastname_ff};position: absolute; user-select: none;transform: translate(${res.data.lastname_x}px,${res.data.lastname_y}px)">${userInfo.last_name}</p>
                    <p ref="student_number" style="font-size:${res.data.student_number_fw}px ;font-family: ${res.data.student_number_ff};position: absolute; user-select: none;transform: translate(${res.data.student_number_x}px,${res.data.student_number_y}px)">${userInfo.student_no}</p>
                    <p ref="course" style="font-size:${res.data.course_fw}px ;font-family: ${res.data.course_ff};position: absolute;  user-select: none;transform: translate(${res.data.course_x}px,${res.data.course_y}px)">${userInfo.course}</p>

                    <img ref="profile" src="storage/studentImage/${element.image}"
                        style="position: absolute;object-fit: cover; object-position: top; user-select: none;width:115px;height:135px;transform: translate(${res.data.profile_x}px,${res.data.profile_y}px)" alt="">

                    <img  src="storage/template/${activeTemplate.value.front}" style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                </div>
                <div class="relative" style="position: relative;">

                    <p ref="year_sem" style="font-size:${res.data.year_sem_fw}px ;font-family: ${res.data.year_sem_ff};position: absolute;  user-select: none;transform: translate(${res.data.year_sem_x}px,${res.data.year_sem_y}px)">${userInfo.school_year_semester.split('/')[1]} 'AY' ${userInfo.school_year_semester.split('/')[0]}</p>


                    <p ref="contact_form" style="font-size:${res.data.contact_form_fw}px ;font-family: ${res.data.contact_form_ff};transform: translate(${res.data.contact_form_x}px,${res.data.contact_form_y}px);position: absolute;  user-select: none;">${userInfo.guardian_name}</p>

<p ref="address" style="line-height: 90%;font-size:${res.data.address_fw}px ;font-family: ${res.data.address_ff};transform: translate(${res.data.address_x}px,${res.data.address_y}px);position: absolute;  user-select: none;max-width: 130px;text-align: center;"">${userInfo.guardian_address}</p>

<p ref="number" style="font-size:${res.data.number_fw}px ;font-family: ${res.data.number_ff};transform: translate(${res.data.number_x}px,${res.data.number_y}px);position: absolute;  user-select: none;">${userInfo.contact_no}</p>

                    <img ref="signature" src="storage/signature/${element.signature}" style="position: absolute; user-select: none; transform: translate(${res.data.signature_x}px,${res.data.signature_y}px);${res.data.signature_w > 0 ? "width:"+res.data.signature_w+"px;" : 'width: 44.6624755859375px;'}${res.data.signature_h > 0 ? "height:"+res.data.signature_h+"px;" : ' height:39.637481689453125px;"'}" alt="">
                    <img  src="storage/template/${activeTemplate.value.back}" style="height: 204.09448819px;width: 323.52755906px; user-select: none;" alt="">
                </div>
            </div>
    `)




                }
            }

        });
    }else{
        checkImage.value = true;
    }

}
onMounted(() =>{
    window.addEventListener("afterprint", (event) => {
  console.log("After print");
});

window.onafterprint = (event) => {
  console.log("After print");
};
})
</script>
