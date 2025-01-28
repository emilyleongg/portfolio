function one_hour_later() {
    let one_hour_later = new Date();
    one_hour_later.setHours(one_hour_later.getHours() + 1);
    return one_hour_later.toUTCString();
}

const textbox = document.getElementById('username');
const form = document.querySelector("form");  // Get the form element

function validate_username(username) {
    let errors = [];
    const validCharacters = /^[a-zA-Z0-9!@#$%^*()\-_+\[\]{}:'|`~<.>\/?]+$/;

    if (username.length < 5) {
        errors.push("Username must be 5 characters or longer.");
    }
    if (username.length > 40) {
        errors.push("Username cannot be longer than 40 characters.");
    }
    if (username.includes(" ")) {
        errors.push("Username cannot contain spaces.");
    }
    if (username.includes(",")) {
        errors.push("Username cannot contain commas.");
    }
    if (username.includes(";")) {
        errors.push("Username cannot contain semicolons.");
    }
    if (username.includes("=")) {
        errors.push("Username cannot contain =.");
    }
    if (username.includes("&")) {
        errors.push("Username cannot contain &.");
    }

    if (errors.length === 0 && !validCharacters.test(username)) {
        errors.push("Username can only use characters from the following string:\n abcdefghijklmnopqrstuvwxyz\n ABCDEFGHIJKLMNOPQRSTUVWXYZ\n 0123456789\n !@#$%^*()-_+[]{}:'|`~<.>/?");
    }

    if (errors.length > 0) {
        alert(errors.join("\n"));
        window.location.reload();
        return false;  // Return false to prevent form submission
    } else {
        // If valid, set the username cookie
        document.cookie = `username=${username}; expires=${one_hour_later()}`;
        return true;  // Return true to allow form submission
    }
}

// Event listener for the login button click
document.getElementById("button").addEventListener("click", function(event) {
    if (!validate_username(textbox.value)) {
        event.preventDefault();  // Prevent form submission if validation fails
    }
});

// Event listener for username field when Enter key is pressed
document.getElementById("username").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        if (!validate_username(textbox.value)) {
            event.preventDefault();  // Prevent form submission if validation fails
        }
    }
});
