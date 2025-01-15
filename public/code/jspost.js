
/**
 * jspost is a javascript post, get and put function created by CodeYro team
 * Author: Tyrone L. Malocon
 * 2025/01/06
 * @param {*}  
 * @param {*}  
 * @param {*}  
 * @returns 
 */

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
                code: 200,
                status: 'ok',
                message: 'Okay',
                data: result,
                result: result,
                backend: result,
            };
        } else {
            ret = {
                code: -1,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: -1,
            status: 'error',
            message: 'Error',
            data: JSON.stringify(data),
            error: error.message || error,
            allerror: error
        };
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
                code: -1,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: -1,
            status: 'error',
            message: 'Error',
            data: JSON.stringify(data),
            error: error.message || error,
            allerror: error
        };
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
                code: 200,
                status: 'ok',
                message: 'Okay',
                data: result,
                result: result,
                backend: result,
            };
        } else {
            ret = {
                code: -1,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: -1,
            status: 'error',
            message: 'Error',
            error: error.message || error,
        };
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
                code: -1,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: -1,
            status: 'error',
            message: 'Error',
            error: error.message || error,
        };
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
                code: 200,
                status: 'ok',
                message: 'Okay',
                data: result,
                result: result,
                backend: result
            };
        } else {
            ret = {
                code: -1,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: -1,
            status: 'error',
            message: 'Error',
            error: error.message || error,
        };
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
                code: -1,
                status: 'error',
                message: `HTTP error! status: ${response.status}`,
                error: `HTTP error! status: ${response.status}`,
            };
            console.error(`HTTP error! status: ${response.status}`);
        }
    } catch (error) {
        ret = {
            code: -1,
            status: 'error',
            message: 'Error',
            error: error.message || error,
        };
    }

    return ret;
}


function get_form_data(id){
    const form = document.querySelector(`#${id}`); 
    const formData = new FormData(form);  

    const dataObject = {};
    formData.forEach((value, key) => {
        dataObject[key] = value;  
    });

    return dataObject; 
}

function on_submit(id, callable) {
    const form = document.getElementById(id);
    if (!form) {
        console.error(`Form with id '${id}' not found.`);
        return;
    }
    form.onsubmit = function (event) {
        callable(event); 
    };
}

function on_click(id, callable) {
    const form = document.getElementById(id);
    if (!form) {
        console.error(`Tag with id '${id}' not found.`);
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

function reload(){
    window.location.reload();
}

function log(text){
    console.log(text);
}

function set_value(name, value, by="name"){
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


function get_value(name, by="name"){
    let element = null;
    if(by=="name"){
       element = document.getElementsByName(name);
    }else{
        element = document.getElementById(name);
    }
    return element.value;
}

function get_element(id){
    return document.getElementById(id);
}

function get_attribute(name, attr, by="id"){
    let element = null;
    if(by=="name"){
       element = document.getElementsByName(name);
    }else{
        element = document.getElementById(name);
    }
    return element.getAttribute(attr);
}


function set_attribute(id, attributes) {
    let el = document.getElementById(id);
    for (let key in attributes) {
        if (attributes.hasOwnProperty(key)) {
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


function set_html(id, strhtml){
    const dive = document.getElementById(id);
    dive.innerHTML = strhtml;
}

function add_html(id, strhtml){
    const dive = document.getElementById(id);
    dive.insertAdjacentHTML('beforeend', strhtml);
}

function js_href(url, target="this"){
    if(target == "this"){
        window.location.href = url;
    }else{
        window.open(url, target);
    }
}






