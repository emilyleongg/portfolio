let haCount = 0;

// Function to mock the user
function mockUser() {
    const password = document.getElementById('password').value; // Get the value of the password input
    haCount++;

    // Update the main heading with additional "HA"s
    const mainHeading = document.getElementById('main-heading');
    mainHeading.innerHTML = 'HA'.repeat(haCount); 

    // Create a mocking message element
    const mockMessage = document.createElement('p');
    mockMessage.innerHTML = `Somebody knows the password you like to use is <b>${password}</b>.`;

    // Append the mocking message to the section
    document.querySelector('section').appendChild(mockMessage);
}

// Event listener for the login button click
document.getElementById('button').addEventListener('click', function(event) { // Keep the ID as 'button'
    event.preventDefault(); // Prevent any default behavior
    mockUser(); // Call the mock function
});

// Event listener for the "Enter" key on the password input field
document.getElementById('password').addEventListener('keydown', function(e) {
    if (e.key === "Enter") { // Check if "Enter" key is pressed
        e.preventDefault(); // Prevent default action (like form submission)
        mockUser(); // Call the mock function
    }
});