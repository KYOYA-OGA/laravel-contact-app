const filterId = document.getElementById("filter_company_id");

if (filterId) {
    filterId.addEventListener("change", function () {
        const companyId = this.value || this.options[this.selectedIndex].value;
        window.location.href = `${
            window.location.href.split("?")[0]
        }?company_id=${companyId}`;
    });
}

const deleteButtons = document.querySelectorAll(".btn-delete");
if (deleteButtons) {
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            if (confirm("Are you sure?")) {
                let action = this.getAttribute("href");
                let form = document.getElementById("form-delete");
                form.setAttribute("action", action);
                form.submit();
            }
        });
    });
}

const clearButton = document.getElementById("btn-clear");
const toggleClearButton = () => {
    const query = location.search;
    const pattern = /[?&]search=/;

    if (pattern.test(query)) {
        clearButton.style.display = "block";
    } else {
        clearButton.style.display = "none";
    }
};
if (clearButton) {
    toggleClearButton();
    clearButton.addEventListener("click", () => {
        const input = document.getElementById("search");
        const select = document.getElementById("filter_company_id");

        input.value = "";
        select.selectedIndex = 0;

        window.location.href = window.location.href.split("?")[0];
    });
}
