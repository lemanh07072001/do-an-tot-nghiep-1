let swalConfig2ButtonConfirm = (title, icon = "warning") => {
    return {
        text: title,
        icon: icon,
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Đòng ý!",
        cancelButtonText: "Không, Quay lại",
        customClass: {
            confirmButton: confirmButton,
            cancelButton: cancelButton
        }
    }
}

let swalConfig1ButtonConfirm = (title, icon = "warning") => {
    return {
        text: title,
        icon: icon,
        buttonsStyling: false,
        confirmButtonText: "Ok, Quay lại!",
        customClass: {
            confirmButton: confirmButton,
        }
    }
}