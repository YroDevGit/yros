
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





