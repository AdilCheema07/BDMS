// This Script updates the status of approved request to either fulfilled or cancelled when the update or cancel button is pressed by the Admin on the Approved Requests Page 

function cancelRequest(requestId) {
    // Send an AJAX request to update the status to "declined"
    console.log("Cancel Request button clicked for Request ID: " + requestId);
    $.ajax({
        type: "POST",
        url: "fulfill_request_status.php",
        data: { requestId: requestId, status: "cancelled" },
        success: function (response) {
            // Reload the page or update the table as needed
            location.reload(); // Reload the page for simplicity
        },
        error: function () {
            alert("Error cancelling the request.");
        }
    });
}


function fulfillRequest(requestId) {
    // Send an AJAX request to update the status to "approved"
    $.ajax({
        type: "POST",
        url: "fulfill_request_status.php",
        data: { requestId: requestId, status: "fulfilled" },
        success: function (response) {
            // Reload the page or update the table as needed
            location.reload(); // Reload the page for simplicity
        },
        error: function () {
            alert("Error fulfill the request.");
        }
    });
}






function fulfillDonation(donationId) {
    // Send an AJAX request to update the donation status to "approved"
    $.ajax({
        type: "POST",
        url: "fulfill_donation_status.php", // Use the correct URL
        data: { donationId: donationId, status: "fulfilled" },
        success: function (response) {
            if (response === "Success") {
                // Reload the page or update the table as needed
                location.reload(); // Reload the page for simplicity
            } else {
                alert("Error fulfilling the donation: " + response);
            }
        },
        error: function () {
            alert("Error fulfilling the donation.");
        }
    });
}


function cancelDonation(donationId) {
    // Send an AJAX request to update the donation status to "declined"
    $.ajax({
        type: "POST",
        url: "fulfill_donation_status.php", // Use the correct URL
        data: { donationId: donationId, status: "cancelled" },
        success: function (response) {
            if (response === "Success") {
                // Reload the page or update the table as needed
                location.reload(); // Reload the page for simplicity
            } else {
                alert("Error cancelling the donation: " + response);
            }
        },
        error: function () {
            alert("Error cancelling the donation.");
        }
    });
}