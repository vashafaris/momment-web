/**
 * Created by Rizal on 3/7/2018.
 */
function formatDate(date) {
    var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];

    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();

    return day + ' ' + monthNames[monthIndex] + ' ' + year;
}

function formatBigNumber(number) {
    if (number >= 1000000)
        return Math.round(number / 100000) / 10 + 'jt';
    else if (number >= 1000)
        return Math.round(number / 100) / 10 + 'rb';
    else
        return number;
}