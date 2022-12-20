<template>
    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column mb-3">
        <div class="row form-group align-items-baseline">
            <div class="col-12 col-md form-group mb-md-0 pe-md-0">
                <div class="form-group">
                    <label for="datetime-picker" class="form-label">Date</label>
                    <div class="input-group">
                        <input type="text"
                               class="form-control flatpickr-input"
                               id="datetime-picker"
                               v-model="date"
                               placeholder="Select date"
                               autocomplete="off"
                        >
                    </div>
                </div>
            </div>
            <div class="col-12 col-md form-group mb-md-0 pe-md-0">
                <div class="form-group">
                    <label for="invoice-type" class="form-label">Invoice Type</label>
                    <div>
                        <select id="invoice-type" class="form-control" v-model="invoiceType">
                            <option value="full">Full</option>
                            <option value="probation">Probation</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 pt-3">
                <button class="btn  btn-default" type="submit" @click="generate()">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="1em" height="1em" viewBox="0 0 32 32"
                         class="me-2" role="img" fill="currentColor" componentname="orchid-icon">
                        <path
                            d="M0 16c0 8.837 7.163 16 16 16s16-7.163 16-16c0-8.836-7.163-16-16-16s-16 7.163-16 16zM30.032 16c0 7.72-6.312 14-14.032 14s-14-6.28-14-14 6.28-14 14-14 14.032 6.28 14.032 14zM14.989 8.99v11.264l-3.617-3.617c-0.39-0.39-1.024-0.39-1.414 0s-0.39 1.023 0 1.414l6.063 5.907 6.063-5.907c0.195-0.195 0.293-0.451 0.293-0.707s-0.098-0.512-0.293-0.707c-0.39-0.39-1.023-0.39-1.414 0l-3.68 3.68v-11.326c0-0.553-0.448-1-1-1s-1.001 0.447-1.001 1z"></path>
                    </svg>
                    Generate Selected
                </button>
            </div>
        </div>
    </div>
    <div class="bg-white rounded shadow-sm mb-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th v-for="column in ['Full Name En', 'Invoice Number', 'Amount', 'Select', 'Generate', 'Edit']"
                        class="text-start">
                        <div>{{ column }}</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="employee in employees">
                    <td class="text-start text-truncate" colspan="1">
                        <div>{{ employee.full_name_en }}</div>
                    </td>
                    <td class="text-start text-truncate" colspan="1">
                        <div><input class="form-control" type="number" v-model="employee.invoice_number"></div>
                    </td>
                    <td class="text-start text-truncate" colspan="1">
                        <div><input class="form-control" type="number" v-model="employee.amount"></div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="form-check">
                                <input value="1" type="checkbox" class="form-check-input" v-model="employee.selected">
                            </div>
                        </div>
                    </td>
                    <td class="text-start text-truncate" colspan="1">
                        <div>
                            <button class="btn btn-default" @click="generate(employee.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="1em" height="1em"
                                     viewBox="0 0 32 32" class="me-2" role="img" fill="currentColor"
                                     componentname="orchid-icon">
                                    <path
                                        d="M0 16c0 8.837 7.163 16 16 16s16-7.163 16-16c0-8.836-7.163-16-16-16s-16 7.163-16 16zM30.032 16c0 7.72-6.312 14-14.032 14s-14-6.28-14-14 6.28-14 14-14 14.032 6.28 14.032 14zM14.989 8.99v11.264l-3.617-3.617c-0.39-0.39-1.024-0.39-1.414 0s-0.39 1.023 0 1.414l6.063 5.907 6.063-5.907c0.195-0.195 0.293-0.451 0.293-0.707s-0.098-0.512-0.293-0.707c-0.39-0.39-1.023-0.39-1.414 0l-3.68 3.68v-11.326c0-0.553-0.448-1-1-1s-1.001 0.447-1.001 1z"></path>
                                </svg>
                                Generate
                            </button>
                        </div>
                    </td>
                    <td class="text-start text-truncate" colspan="1">
                        <div>
                            <a data-turbo="true" class="btn btn-link"
                               :href="'/admin/employee/' + employee.id + '/edit'">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="1em" height="1em"
                                     viewBox="0 0 32 32" class="me-2" role="img" fill="currentColor"
                                     componentname="orchid-icon">
                                    <path
                                        d="M30.133 1.552c-1.090-1.044-2.291-1.573-3.574-1.573-2.006 0-3.47 1.296-3.87 1.693-0.564 0.558-19.786 19.788-19.786 19.788-0.126 0.126-0.217 0.284-0.264 0.456-0.433 1.602-2.605 8.71-2.627 8.782-0.112 0.364-0.012 0.761 0.256 1.029 0.193 0.192 0.45 0.295 0.713 0.295 0.104 0 0.208-0.016 0.31-0.049 0.073-0.024 7.41-2.395 8.618-2.756 0.159-0.048 0.305-0.134 0.423-0.251 0.763-0.754 18.691-18.483 19.881-19.712 1.231-1.268 1.843-2.59 1.819-3.925-0.025-1.319-0.664-2.589-1.901-3.776zM22.37 4.87c0.509 0.123 1.711 0.527 2.938 1.765 1.24 1.251 1.575 2.681 1.638 3.007-3.932 3.912-12.983 12.867-16.551 16.396-0.329-0.767-0.862-1.692-1.719-2.555-1.046-1.054-2.111-1.649-2.932-1.984 3.531-3.532 12.753-12.757 16.625-16.628zM4.387 23.186c0.55 0.146 1.691 0.57 2.854 1.742 0.896 0.904 1.319 1.9 1.509 2.508-1.39 0.447-4.434 1.497-6.367 2.121 0.573-1.886 1.541-4.822 2.004-6.371zM28.763 7.824c-0.041 0.042-0.109 0.11-0.19 0.192-0.316-0.814-0.87-1.86-1.831-2.828-0.981-0.989-1.976-1.572-2.773-1.917 0.068-0.067 0.12-0.12 0.141-0.14 0.114-0.113 1.153-1.106 2.447-1.106 0.745 0 1.477 0.34 2.175 1.010 0.828 0.795 1.256 1.579 1.27 2.331 0.014 0.768-0.404 1.595-1.24 2.458z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import TomSelect from 'tom-select';
import {onMounted, ref, watch} from 'vue'

const employees = ref([])
const invoiceType = ref('full')
const date = ref((new Date()).toISOString().split('T')[0])

watch(invoiceType, () => {
    getEmployees()
})

function getEmployees() {
    axios.get('/admin/platformapi/invoices', {
        params: {
            date: date.value,
            invoice_type: invoiceType.value,
        }
    })
        .then((res) => {
            employees.value = res.data
        })
}

function generate(employeeId = null) {
    const params = {
        date: date.value,
        invoice_type: invoiceType.value,
        employees: []
    }

    const selected = []
    if (employeeId) {
        selected.push(employeeId)
    } else {
        // if none employee is selected than everyone is selected
        if (employees.value.every((e) => !e.selected)) {
            selected.push(...employees.value.map(e => e.id))
        } else {
            selected.push(...employees.value.filter(e => e.selected).map(e => e.id))
        }
    }

    employees.value.forEach((employee) => {
        if (selected.includes(employee.id)) {
            params.employees.push({
                id: employee.id,
                amount: employee.amount,
                invoice_number: employee.invoice_number,
            })
        }
    })

    axios({
        url: '/admin/platformapi/invoices/generate',
        method: 'post',
        responseType: 'blob',
        params: params
    })
        .then((response) => {
            let filename = response.headers['content-disposition']
                .split(';')[1]
                .split('=')[1]
                .replace('"', '')
                .replace('"', '');

            const href = URL.createObjectURL(response.data);
            const link = document.createElement('a');
            link.href = href;
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();

            document.body.removeChild(link);
            URL.revokeObjectURL(href);
        })
}

onMounted(() => {
    flatpickr('#datetime-picker')
    new TomSelect('#invoice-type', {});

    getEmployees()
})
</script>
