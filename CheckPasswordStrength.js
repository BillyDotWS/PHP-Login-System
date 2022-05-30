$(document).ready(function () {  
    $('#txtPassword').keyup(function () {  
        $('#strengthMessage').html(checkStrength($('#txtPassword').val()))  
    })  
    function checkStrength(password) {  
        var strength = 0  
        if (password.length < 8) {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Short')  
            return 'Too short'  
        }  
        if (password.length >= 8) strength += 1  
        // If password contains lower characters, increase strength value.  
        if (password.match(/([a-z]+)/) && password.match(/([A-Z]+)/)) strength += 1  
        // If it has numbers and characters, increase strength value.  
        if (password.match(/([0-9]+)/)) strength += 1  
         
        // Calculated strength value, we can return messages  
        // If value is less than 2  
        if (strength < 2) {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Weak')  
            return 'Weak'  
        } else if (strength == 2) {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Good')  
            return 'Good'  
        } else {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Strong')  
            return 'Strong'  
        }  
    }  
}); 