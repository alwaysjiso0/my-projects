$(document).ready(function () {
    /* 10/16 UPDATED Jisoo Choi */
    // addClass for options in start.html
    $('.user_occupation').change(function () {
        var clicked = $(this).val();
        if (clicked == "student") {
            $('.student').addClass('on').siblings().removeClass('on');
        }
        if (clicked == "family") {
            $('.family').addClass('on').siblings().removeClass('on');
        }
        if (clicked == "worker") {
            $('.worker').addClass('on').siblings().removeClass('on');
        }
    });

    // saving user input from start
    $(".user_occupation", ".user_children").change(function () {
        if ($(this).val() == "0") $(this).addClass("empty");
        else $(this).removeClass("empty")
    });

    $(".user_occupation", ".user_children").change();

    $('.next_btn').click(function () {
        var username_data = $('.user_name').val();
        username_data = decodeURI(JSON.stringify(username_data));

        var useroccupation_data = $('.user_occupation').val();
        useroccupation_data = JSON.stringify(useroccupation_data);

        var userschool_data = $('.user_school').val();
        userschool_data = JSON.stringify(userschool_data);

        var userchildren_data = $('.user_children').val();
        userchildren_data = JSON.stringify(userchildren_data);

        var userworkplace_data = $('.user_workplace').val();
        userworkplace_data = JSON.stringify(userworkplace_data);

        if (window.sessionStorage) {
            sessionStorage.setItem('username_data', username_data);
            sessionStorage.setItem('useroccupation_data', useroccupation_data);
            sessionStorage.setItem('userschool_data', userschool_data);
            sessionStorage.setItem('userchildren_data', userchildren_data);
            sessionStorage.setItem('userworkplace_data', userworkplace_data);
        }

        if (window.sessionStorage) {
            var userName = JSON.parse(sessionStorage.getItem('username_data'));
            var userOccupation = JSON.parse(sessionStorage.getItem('useroccupation_data'));
            var userSchool = JSON.parse(sessionStorage.getItem('userschool_data'));
            var userChildren = JSON.parse(sessionStorage.getItem('userchildren_data'));
            var userWork = JSON.parse(sessionStorage.getItem('userworkplace_data'));
            console.log(userName);
            console.log(userOccupation);
            console.log(userSchool);
            console.log(userChildren);
            console.log(userWork);
        }
    })

    if (window.sessionStorage) {
        var userName = JSON.parse(sessionStorage.getItem('username_data'));
        var userOccupation = JSON.parse(sessionStorage.getItem('useroccupation_data'));
        var userSchool = JSON.parse(sessionStorage.getItem('userschool_data'));
        var userChildren = JSON.parse(sessionStorage.getItem('userchildren_data'));
        var userWork = JSON.parse(sessionStorage.getItem('userworkplace_data'));
        console.log(userName);
        console.log(userOccupation);
        console.log(userSchool);
        console.log(userChildren);
        console.log(userWork);
    }
    $('.user_name_input').text(userName);

    /* 10/09 UPDATED Jisoo Choi */
    // start.html skip_popup
    $('.skip_btn').click(function () {
        $('#skip_popup').addClass('on').removeClass('off');
    });
    $('.stay').click(function () {
        $(this).parents('#skip_popup').addClass('off').removeClass('on');
    });

    /* 10/16 UPDATED Jisoo Choi */
    // recommendations

    var toowong_desc = "Toowong is a popular suburb near the city and University of Queensland UQ). Housing rent is more affordable than St Lucia where UQ campus is located. It is also easy for people without a car to get around the city with public transportation options including a City Cat stop on major road Coronation Drive, and train station connected to a nearby shopping centre. Also, many bus routes stop in Toowong with frequent services. There are number of bars and pubs that are loved by students.";
    var westEnd_desc = "West End is the best location for students of schools located across the river like University of Queensland(UQ) or Queensland University of Technology (QUT). The location is well preferred by students in Brisbane, but the housing can be pricey and scarce. Students in this area would most likely live with housemates. West End benifits its locals with the best mix of international cuisine restaurants, bars, pubs, and a rather bohemian vibe.";
    var woolloongabba_desc = "Wooloongabba is a busy hub just next to Brisbane CBD, located across major intersections and many roads. The place is close to schools as University of Queensland (UQ) and is in a walking distance to QUT Gardens Point. With an abundancy of transportations, Wooloongabba has buses connecting to all corners of Brisbane. There are many bars, restaurants to satisfy young people, and sporting events are held at the 'Gabba' (Brisbane Cricket Ground) providing a rich culture. Enjoy an urban life in Wooloongabba!";
    var kelvin_desc = "Kelvin Grove is a modern, funky urban village that is nice for students and young people. QUT's Kelvin Grove Campus that is located here providing a modern community with facilities including the Roundhouse theatre, speciality shops, cafes, bars and more. There are many student housings here with apartments and townhouses that are also modern in design. There is also a free shuttle for QUT students to the city by taking the QUT shuttle bus. Kelvin Grove is rich in cultural and artistic flavour to the already diverse suburb.";
    var eastBrisbane_desc = "East Brisbane is located east of downtown. It is a popular suburb for international students thanks to the large number of student housing buildings. Many apartments offer short term accommodation which is convenient for students who are planning to stay for a shorter time. East Brisbane is also near the Mowbray Park City Cat terminal so it is easy to access to Fortitude Valley which lies just over the Storey Bridge.";
    var mount_desc = "Mount Gravatt is somewhat further outside central Brisbane to the southside. There are many benefits for those who live in Mount Gravatt and students attending Griffith University campuses which surround the suburb. Mount Gravatt is a small city in itself and covers up to a wider area to Upper Mt Gravatt, Mt Gravatt East and Mt Gravatt proper. Since it is not central in CBD, there are various housing options available and at a much more affordable price. Garden City shopping centre in Mt Gravatt offers lots of shopping and entertainment options and it has nice public transport to Brisbane City.";
    var victoria_desc = "Victoria Point is a lush, kid-friendly neighborhood located approximately 20 miles from the centre of Brisbane. It is popular for retired seniors and is especially loved by families with children because it is close to several schools. There are three public schools and two private schools, so parents have a variety of learning options to choose from. In addition, Victoria Point is close to Thompson’s Beach, which has a beautiful sandy beach that is best for a family outing. There are other family-friendly facilities including shopping centres, large grocery stores, a community library, a movie theatre, and a variety of local stores.";
    var holland_desc = "Holland Park is a safe, beautiful suburb located not too far from the centre of Brisbane. Some homes are slightly older in this area, meaning there are reasonably priced houses for buyers who have a limited budget. Holland Park is perfect for families with kids since it has spacious parks, nice nearby schools, a library, and a shopping plaza. The neighbourhood has great public transportation system, so you don't require a car while raising a family Brisbane.";
    var wilston_desc = "Wilston is a great choice for you if you earn a decent income and have a family to raise. It is a beautiful little neighbourhood and one of the best suburbs Brisbane. Wilston is on a hill with wonderful views of the city. There's a beautifully architectured neighbourhood shopping street with nice restaurants and fantastic nearby parks and beaches where your family can unwind. It's also close to the Royal Brisbane Hospital, many good schools, and the railway.";
    var fortitude_desc = "Fortitude Valley is also known as “the Valley”. It is one of Brisbane’s most well-known suburbs thanks to its vibrant nightlife, cafe culture, and Chinatown mall. Fortitude Valley offers residents easy access to parklands and education facilities. It is located under two kilometres from the CBD. Fortitude Valley is a nine minute drive to the city centre, and only takes 12-minutes to commute by public transport.";
    var southBrisbane_desc = "South Brisbane is a riverside suburb located on the southern banks of the Brisbane River. It is close to the central business district (CBD) by the Kurilpa, Victoria and Goodwill bridges. It only takes nine minutes by car to the city centre or takes just 11 minutes by public transport. It is close to many education facilities and has abundant parklands within easy reach.";
    var springHill_desc = "Spring Hill is an inner suburb of Brisbane very closely located from the CBD. Just two kilometres, so close that some parts can be considered as an extension of the CBD. It takes five minutes by car to the city centre or just 19 minutes using public transport. The suburb has plenty of parklands and Victorian-era landmarks. It is close to many education facilities and have parks within close reach.";
    var kangarooPoint_desc = "Kangaroo Point is a riverside suburb located across the Brisbane River east of the CBD. It takes 8 minutes by car to the city centre or 24 minutes by public transport. The area is famous for its landmarks Kangaroo Point Cliffs and Story Bridge. Residents live close to a park and they have education facilities nearby.";


    if (userOccupation == "student" && userSchool == "UQ") {
        $('.recommend_content .first .description .rec_title').text("Toowong");
        $('.recommend_content .first .description .rec_desc').html(toowong_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/Toowong.jpg');
        $('.recommend_content .second .description .rec_title').text("Woolloongabba");
        $('.recommend_content .second .description .rec_desc').html(woolloongabba_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/Woolloongabba.jpg');
        $('.recommend_content .third .description .rec_title').text("West End");
        $('.recommend_content .third .description .rec_desc').html(westEnd_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/WestEnd.jpg');
    }

    if (userOccupation == "student" && userSchool == "QUT") {
        $('.recommend_content .first .description .rec_title').text("East Brisbane");
        $('.recommend_content .first .description .rec_desc').html(eastBrisbane_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/EastBrisbane.jpg');
        $('.recommend_content .second .description .rec_title').text("Kelvin Grove");
        $('.recommend_content .second .description .rec_desc').html(kelvin_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/KelvinGrove.jpg');
        $('.recommend_content .third .description .rec_title').text("Woolloongabba");
        $('.recommend_content .third .description .rec_desc').html(woolloongabba_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/Woolloongabba.jpg');
    }

    if (userOccupation == "student" && userSchool == "Griffith") {
        $('.recommend_content .first .description .rec_title').text("Mount Gravatt");
        $('.recommend_content .first .description .rec_desc').html(mount_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/MountGravatt.jpg');
        $('.recommend_content .second .description .rec_title').text("East Brisbane");
        $('.recommend_content .second .description .rec_desc').html(eastBrisbane_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/EastBrisbane.jpg');
        $('.recommend_content .third .description .rec_title').text("Woolloongabba");
        $('.recommend_content .third .description .rec_desc').html(woolloongabba_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/Woolloongabba.jpg');
    }

    if (userOccupation == "student" && userSchool == "TAFE") {
        $('.recommend_content .first .description .rec_title').text("West End");
        $('.recommend_content .first .description .rec_desc').html(westEnd_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/WestEnd.jpg');
        $('.recommend_content .second .description .rec_title').text("Kelvin Grove");
        $('.recommend_content .second .description .rec_desc').html(kelvin_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/KelvinGrove.jpg');
        $('.recommend_content .third .description .rec_title').text("Woolloongabba");
        $('.recommend_content .third .description .rec_desc').html(woolloongabba_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/Woolloongabba.jpg');
    }

    if (userOccupation == "family") {
        $('.recommend_content .first .description .rec_title').text("Victoria Point");
        $('.recommend_content .first .description .rec_desc').html(victoria_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/VictoriaPoint.jpg');
        $('.recommend_content .second .description .rec_title').text("Holland Park");
        $('.recommend_content .second .description .rec_desc').html(holland_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/HollandPark.jpg');
        $('.recommend_content .third .description .rec_title').text("Wilston");
        $('.recommend_content .third .description .rec_desc').html(wilston_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/Wilston.jpg');
    }

    if (userOccupation == "worker" && userWork == "no") {
        $('.recommend_content .first .description .rec_title').text("Fortitude Valley");
        $('.recommend_content .first .description .rec_desc').html(fortitude_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/FortitudeValley.jpg');
        $('.recommend_content .second .description .rec_title').text("Toowong");
        $('.recommend_content .second .description .rec_desc').html(toowong_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/Toowong.jpg');
        $('.recommend_content .third .description .rec_title').text("Mount Gravatt");
        $('.recommend_content .third .description .rec_desc').html(mount_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/MountGravatt.jpg');
    }

    if (userOccupation == "worker" && userWork == "yes") {
        $('.recommend_content .first .description .rec_title').text("South Brisbane");
        $('.recommend_content .first .description .rec_desc').html(southBrisbane_desc);
        $('.recommend_content .first .rec_img').attr('src', './images/SouthBrisbane.jpg');
        $('.recommend_content .second .description .rec_title').text("Spring Hill");
        $('.recommend_content .second .description .rec_desc').html(springHill_desc);
        $('.recommend_content .second .rec_img').attr('src', './images/SpringHill.jpg');
        $('.recommend_content .third .description .rec_title').text("Kangaroo Point");
        $('.recommend_content .third .description .rec_desc').html(kangarooPoint_desc);
        $('.recommend_content .third .rec_img').attr('src', './images/KangarooPoint.jpg');
    }

    /* 10/21 UPDATED Jisoo Choi */
    if (userOccupation == 0 || userOccupation == null) {
        $('#refreshButton').on('click', function () {
            var result = confirm("We need more information to use this function. \nDo you want to enter user information?");
            if (result) {
                location.replace('start.html');
            } else {
                location.replace('map.html');
            }
        })
    }
    /* 10/21 UPDATED Jisoo Choi */
    if (userOccupation == "student") {
        if (userSchool == 0) {
            $('#refreshButton').on('click', function () {
                var result = confirm("We need more information to use this function. \nDo you want to enter user information?");
                if (result) {
                    location.replace('start.html');
                } else {
                    location.replace('map.html');
                }
            })
        }
    }
    /* 10/21 UPDATED Jisoo Choi */
    if (userOccupation == "family") {
        if (userChildren == 0) {
            $('#refreshButton').on('click', function () {
                var result = confirm("We need more information to use this function. \nDo you want to enter user information?");
                if (result) {
                    location.replace('start.html');
                } else {
                    location.replace('map.html');
                }
            })
        }
    }
    /* 10/21 UPDATED Jisoo Choi */
    if (userOccupation == "worker") {
        if (userWork == 0) {
            $('#refreshButton').on('click', function () {
                var result = confirm("We need more information to use this function. \nDo you want to enter user information?");
                if (result) {
                    location.replace('start.html');
                } else {
                    location.replace('map.html');
                }
            })
        }
    }

    /* 10/19 UPDATED  Chenshuo Zhang */
    // faq.html
    $('.arrow_down').on('click', function () {
        $(this).parents('.questionbox').siblings('.answer').slideToggle();
    })
    $('.btn').on('click', function () {
        $(this).parents('.questionbox').siblings('.answer').slideToggle();
    })
    
});

// Save the form info in HTML local storage
function store() {
    var userName = document.getElementById("userName");
    localStorage.setItem("userName", userName.value);
}

// // use the name from the stored value to show on the map page 
// // var storedValue = localStorage.getItem("userName");
// document.getElementById("userName").innerHTML = localStorage.getItem("userName");