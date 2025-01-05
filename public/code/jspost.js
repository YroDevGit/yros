
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
            error: error.message || error,
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


function get_form_data(id){
    const form = document.querySelector(`#${id}`); 
    const formData = new FormData(form);  

    const dataObject = {};
    formData.forEach((value, key) => {
        dataObject[key] = value;  
    });

    return dataObject; 
}




