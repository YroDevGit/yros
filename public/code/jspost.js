
/**
 * jspost is a javascript post, get and put function created by CodeYro team
 * Author: Tyrone L. Malocon
 * 2025/01/06
 * @param {*}  
 * @param {*}  
 * @param {*}  
 * @returns 
 */
const jserrorcode =-1;
const jssuccesscode = 200;

async function jspost(url, data, headers = { 'Content-Type': 'application/json' }) {
    let ret = { code: -1, status: 'error', message: 'error message' };

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const result = await response.json();
            ret = {
                code: jssuccesscode,
                backendcode: result.code || 0,
                status: 'ok',
                message: result.message || 'Okay',
                data: result.data || [],
                result: result,
                backend: result,
                body: data,
                headers: headers,
                url: url
            };
        } else {
            ret = {
                code: jserrorcode,
                backendcode: 404,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
                body: data,
                headers: headers,
                url: url
            };
            console.error(ret);
        }
    } catch (error) {
        ret = {
            code: jserrorcode,
            status: 'error',
            backendcode: 404,
            message: error.message || 'Error',
            body: data,
            error: error.message || error,
            allerror: error,
            headers: headers,
            url: url
        };
        console.error(ret);
    }

    return ret;
}

async function jspost_plain(url, data, headers = { 'Content-Type': 'application/json' }) {
    let ret = null;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const result = await response.json();
            ret = result;
        } else {
            ret = {
                code: jserrorcode,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: jserrorcode,
            status: 'error',
            message: 'Error',
            data: JSON.stringify(data),
            error: error.message || error,
            allerror: error
        };
        console.error(ret);
    }

    return ret;
}

async function jsget(url, headers = { 'Content-Type': 'application/json' }) {
    let ret = { code: -1, status: 'error', message: 'error message' };

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: headers,
        });

        if (response.ok) {
            const result = await response.json();
            ret = {
                code: jssuccesscode,
                backendcode: result.code || 0,
                status: 'ok',
                message: result.message || 'Okay',
                data: result.data || [],
                result: result,
                backend: result,
                headers: headers,
                url: url
            };
        } else {
            ret = {
                code: jserrorcode,
                backendcode: 404,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
                headers: headers,
                url: url
            };
            console.error(ret);
        }
    } catch (error) {
        ret = {
            code: jserrorcode,
            backendcode: 404,
            status: 'error',
            allerror: error,
            message: error.message || error,
            error: error.message || error,
            headers: headers,
            url: url
        };
        console.error(ret);
    }

    return ret;
}

async function jsget_plain(url, headers = { 'Content-Type': 'application/json' }) {
    let ret = { code: -1, status: 'error', message: 'error message' };

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: headers,
        });

        if (response.ok) {
            const result = await response.json();
            ret = result;
        } else {
            ret = {
                code: jserrorcode,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: jserrorcode,
            status: 'error',
            message: 'Error',
            error: error.message || error,
        };
        console.error(ret);
    }

    return ret;
}

async function jsput(url, data, where = {}, headers = { 'Content-Type': 'application/json' }) {
    let ret = { code: -1, status: 'error', message: 'error message' };
    const queryParams = new URLSearchParams(where).toString();
    const fullUrl = queryParams ? `${url}?${queryParams}` : url;

    try {
        const response = await fetch(fullUrl, {
            method: 'PUT',
            headers: headers,
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const result = await response.json();
            ret = {
                code: jssuccesscode,
                backendcode: result.code || 0,
                status: 'ok',
                message: result.message || 'Okay',
                data: result.data || [],
                result: result,
                backend: result,
                body: data,
                headers: headers,
                url: url
            };
        } else {
            ret = {
                code: jserrorcode,
                backendcode: 404,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
                body: data,
                headers: headers,
                url: url
            };
            console.error(ret);
        }
    } catch (error) {
        ret = {
            code: jserrorcode,
            backendcode: 404,
            status: 'error',
            allerror: error,
            message: error.message || 'Error',
            error: error.message || error,
            body: data,
            headers: headers,
            url: url
        };
        console.error(ret);
    }

    return ret;
}

async function jsput_plain(url, data, where = {}, headers = { 'Content-Type': 'application/json' }) {
    let ret = { code: -1, status: 'error', message: 'error message' };
    const queryParams = new URLSearchParams(where).toString();
    const fullUrl = queryParams ? `${url}?${queryParams}` : url;

    try {
        const response = await fetch(fullUrl, {
            method: 'PUT',
            headers: headers,
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const result = await response.json();
            ret = result;
        } else {
            ret = {
                code: jserrorcode,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: jserrorcode,
            status: 'error',
            message: 'Error',
            error: error.message || error,
        };
        console.error(ret);
    }

    return ret;
}


function get_form_data(selector){
    let form  = null;
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        form = document.querySelector(selector);
    }else{
        form = document.querySelector(`#${selector}`); 
    }

    if (!form) return null;

    const formData = new FormData(form);  

    const dataObject = {};
    formData.forEach((value, key) => {
        dataObject[key] = value;  
    });

    return dataObject; 
}


function on_submit(selector, callable) {
    let form = null;
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        form = document.querySelector(selector);
    }else{
        form = document.getElementById(selector);
    }
    if (!form) {
        console.error(`Form with id '${selector}' not found.`);
        return;
    }
    if (typeof callable !== "function") {
        console.error("Callable is not a function.");
        return;
    }
    form.onsubmit = function (event) {
        callable(event); 
    };
}

function on_click(selector, callable) {
    let form = null;
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        form = document.querySelector(selector);
    }else{
        form = document.getElementById(selector);
    }
    if (!form) {
        console.error(`Tag with id '${selector}' not found.`);
        return;
    }
    if (typeof callable !== "function") {
        console.error("Callable is not a function.");
        return;
    }
    form.onclick = function (event) {
        callable(event); 
    };
}

function filter_json_array(data, column, contains, wildcard = "%") {
    let filteredData;
    
    if (wildcard === "%") {
        filteredData = data.filter(item => item[column].includes(contains));
    } else {
        filteredData = data.filter(item => item[column] === contains);
    }
    
    return filteredData;
}

function direct_post(id, url, data=null, headers = { 'Content-Type': 'application/json' }){
    const formdata = get_form_data(id);
    if(data==null || data.length === 0){
        data = formdata;
    }
    return jspost(url,data,headers);
}


function direct_get(url, data = null, headers = { 'Content-Type': 'application/json' }) {
    if (data == null || Object.keys(data).length === 0) {
        return jsget(url, headers);
    } else {
        const queryParams = new URLSearchParams(data).toString();
        url = `${url}?${queryParams}`;
        return jsget(url, headers);
    }
}


function window_loaded(callable){
    window.addEventListener("load", callable());
}

function on_load(callable){
    window.addEventListener("load", callable());
}

function reload(){
    window.location.reload();
}

function log(text){
    console.log(text);
}

function set_value(name, value, by="id"){
    let element = null;
    if(by=="name"){
       element = document.getElementsByName(name);
    }else{
        element = document.getElementById(name);
    }
    element.value = value;
}

function set_values(array, by="name"){
    let element = null;
    for (let key in array){
        if(by=="name"){
            element = document.getElementsByName(key);
         }else{
             element = document.getElementById(key);
         } 
         element.value = array[key];
    }  
}


function set_form_values(form, array, by="name") {
    let element;
    for (let key in array) {
        if (by == "name") {
            element = document.querySelector(`#${form} *[name="${key}"]`);
        } else {
            element = document.querySelector(`#${form} *[id="${key}"]`);
        }
        if (element) {
            element.value = array[key];
        } else {
            console.warn(`No input found for ${key} in form ${form}`);
        }
    }
}

function set_form_data(form, array, by="name") {
    return set_form_values(form, array, by);
}


function get_form_value(form, name, by="name"){
    let element;
    if (by == "name") {
        element = document.querySelector(`#${form} *[name="${name}"]`);
    } else {
        element = document.querySelector(`#${form} *[id="${name}"]`);
    }
    if (element) {
        
    } else {
        console.warn(`No input found for ${name} in form ${form}`);
    }

    return element.value;
}

function get_form_values(id){
    return get_form_data(id)
}

function get_value(selector) {
    let element = null;
    
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        element = document.querySelector(selector);
    } else {
        element = document.getElementById(selector);
    }

    return element ? element.value : null; // Return null if element is not found
}


function get_element(selector){
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        return document.querySelector(selector);
    }else{
        return document.getElementById(selector);
    }
}

function get_attribute(selector, attr) {
    let element = null;
    
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        element = document.querySelector(selector);
    } else {
        element = document.getElementById(selector);
    }

    return element ? element.getAttribute(attr) : null; 
}



function set_attribute(selector, attributes) { // attributes should be an object, not an array
    let el = null;

    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        el = document.querySelector(selector);
    } else {
        el = document.getElementById(selector);
    }

    if (!el) return; // Prevent errors if element is not found

    for (let key in attributes) {
        if (Object.prototype.hasOwnProperty.call(attributes, key)) {
            el.setAttribute(key, attributes[key]);
        }
    }
}


function js_tostring(array){
    return JSON.stringify(array);
}

function js_stringfy(array){
    return js_tostring(array);
}

function js_toarray(string){
    return JSON.parse(string);
}

function json_stringfy(array){
    return js_tostring(array);
}

function json_parse(string){
    return js_toarray(string);
}

function set_html(selector, strhtml){
    let dive = null;
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        dive = document.querySelector(selector);
    }else{
        dive = document.getElementById(selector);
    }
    dive.innerHTML = strhtml;
}

function add_html(selector, strhtml){
    let dive = null;
    if (selector.charAt(0) === "#" || selector.charAt(0) === ".") {
        dive = document.querySelector(selector);
    }else{
        dive = document.getElementById(selector);
    }
    dive.insertAdjacentHTML('beforeend', strhtml);
}

function js_href(url, target="this"){
    if(target == "this"){
        window.location.href = url;
    }else{
        window.open(url, target);
    }
}

function js_selector(selector){
    return document.querySelector(selector);
}

function js_selector_all(selector){
const elements = document.querySelectorAll(selector);
return elements;
}

function get_selector_value(selector){
    return document.querySelector(selector).value;
}

function js_timer(timer, callable){
    setTimeout(callable, timer);
}

function js_interval(timmer, callable){
    setInterval(callable, timmer);
}
function set_session(key, value){
    sessionStorage.setItem(key,value);
}

function get_session(key){
    return sessionStorage.getItem(key);
}

function remove_session(key){
    sessionStorage.removeItem(key);
}

function clear_session(){
    sessionStorage.clear();
}

const jsform_validate = (formData, rules) => { // usage: rules = {"fname==Firstname": "required"}
    const errors = {};

    for (const [key, validation] of Object.entries(rules)) {
        let fieldName, label;

        if (key.includes("==")) {
            [fieldName, label] = key.split("==");
            label = label || fieldName;
        } else {
            fieldName = key;
            label = fieldName;
        }

        const value = formData.get(fieldName) || ""; 
        const fieldRules = validation.split("|"); 

        for (const rule of fieldRules) {
            const [ruleName, ruleParam] = rule.includes(":") ? rule.split(":") : [rule, null];

            switch (ruleName) {
                case "required":
                    if (!value.trim()) {
                        errors[fieldName] = `${label} is required.`;
                        break;
                    }
                    break;

                case "number":
                case "numeric":
                    if (isNaN(value)) {
                        errors[fieldName] = `${label} should be a number.`;
                        break;
                    }
                    break;

                case "alphabet":
                    if (!/^[a-zA-Z]+$/.test(value)) {
                        errors[fieldName] = `${label} should contain only alphabets.`;
                        break;
                    }
                    break;

                case "modern-password":
                    if (!/(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/.test(value)) {
                        errors[fieldName] = `${label} should contain letters, numbers, and symbols.`;
                        break;
                    }
                    break;

                case "max":
                    if (Number(value) > Number(ruleParam)) {
                        errors[fieldName] = `${label} should not exceed ${ruleParam}.`;
                        break;
                    }
                    break;

                case "min":
                    if (Number(value) < Number(ruleParam)) {
                        errors[fieldName] = `${label} should not be less than ${ruleParam}.`;
                        break;
                    }
                    break;

                case "size":
                    if (value.length !== Number(ruleParam)) {
                        errors[fieldName] = `${label} should have exactly ${ruleParam} character(s).`;
                        break;
                    }
                    break;

                case "length":
                    if (value.length > Number(ruleParam)) {
                        errors[fieldName] = `${label} should not exceed ${ruleParam} characters.`;
                        break;
                    }
                    break;

                default:
                    break;
            }

            if (errors[fieldName]) break; 
        }
    }

    return errors;
};

function jsinput_to_base64(selector){
    return new Promise((resolve, reject) => {
        const fileInput = document.querySelector(selector);

        if (fileInput.files.length === 0) {
            reject('No file selected.');
            return;
        }

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const base64Encoded = e.target.result.split(',')[1];
            const mimeType = file.type; 
            const fullDataUrl = `data:${mimeType};base64,${base64Encoded}`; 
            resolve(fullDataUrl); 
        };
        reader.onerror = function () {
            reject('Error reading the file.');
        };

        reader.readAsDataURL(file);
    });
}



async function jsfile_to_base64(filePath) {
    try {
        const response = await fetch(filePath); 
        const blob = await response.blob(); 
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result); 
            reader.onerror = reject; 
            reader.readAsDataURL(blob);
        });
    } catch (error) {
        console.error('Error fetching the file:', error);
        throw error;
    }
}


function jsdownload_base64(base64Data, fileName) {
    const [mimeTypePart, base64Content] = base64Data.split(',');
    const mimeType = mimeTypePart.match(/:(.*?);/)[1]; 

    const mimeToExtension = {
        "image/png": "png",
        "image/jpeg": "jpg",
        "image/gif": "gif",
        "text/plain": "txt",
        "application/pdf": "pdf",
        "application/msword": "doc",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document": "docx",
        "application/vnd.ms-excel": "xls",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": "xlsx",
        "application/vnd.ms-powerpoint": "ppt",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation": "pptx",
        "audio/mpeg": "mp3",
        "video/mp4": "mp4",
        "application/zip": "zip",
        "application/x-rar-compressed": "rar"
    };

    const extension = mimeToExtension[mimeType] || "bin"; 

    if (!fileName.includes('.')) {
        fileName = `${fileName}.${extension}`;
    }

    const binaryString = atob(base64Content);
    const binaryLength = binaryString.length;
    const bytes = new Uint8Array(binaryLength);
    for (let i = 0; i < binaryLength; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }

    const blob = new Blob([bytes], { type: mimeType });

    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = fileName; 
    document.body.appendChild(link); 
    link.click(); 
    document.body.removeChild(link); 
}


function jsimg_base64(imgselector, base64){
    document.querySelector(imgselector).src = base64;
}

function jsscroll(selector, attr){
    document.querySelector(selector).scrollTo(attr);
}




