
var searchValue = "";

document.querySelector("input[name='search']").addEventListener("input", function() {

searchValue = this.value;

var filteredCheckboxes = document.querySelectorAll("input[type='checkbox']");
    filteredCheckboxes.forEach(function(checkbox) {

        if (searchValue == "") {
            checkbox.disabled = false;
            checkbox.nextElementSibling.style.color = "gray";
            checkbox.nextElementSibling.style.fontWeight = "normal";
        } else if (checkbox.value.toLowerCase().includes(searchValue.toLowerCase())) {
            checkbox.disabled = false;
            checkbox.nextElementSibling.style.color = "black";
            checkbox.nextElementSibling.style.fontWeight = "bold";
        } else {
            checkbox.disabled = true;
            checkbox.nextElementSibling.style.color = "red";
            checkbox.nextElementSibling.style.fontWeight = "normal";
        }
    });
});
