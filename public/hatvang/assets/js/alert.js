async function alertSuccess(title, text) {
    await Swal.fire({
        icon: "success",
        title: title,
        text: text
    });
}

async function alertError(title, text) {
    await Swal.fire({
        icon: "error",
        title: title,
        text: text
    });
}

async function alertWarning(title, text) {
    await Swal.fire({
        icon: "warning",
        title: title,
        text: text
    });
}