// function handleFileSelect(evt) {
//     var files = evt.target.files; // FileList object
//
//     console.log(evt.nextElementSibling);
//
//     // Loop through the FileList and render image files as thumbnails.
//     for (var i = 0, f; f = files[i]; i++) {
//
//         // Only process image files.
//         if (!f.type.match('image.*')) {
//             continue;
//         }
//
//         var reader = new FileReader();
//
//         // Closure to capture the file information.
//         reader.onload = (function(theFile) {
//             return function(e) {
//                 // // Render thumbnail.
//                 // var span = document.createElement('span');
//                 // span.innerHTML = ['<img class="thumb" src="', e.target.result,
//                 //     '" title="', escape(theFile.name), '"/>'].join('');
//                 // document.getElementById('list').insertBefore(span, null);
//             };
//         })(f);
//
//         // Read in the image file as a data URL.
//         reader.readAsDataURL(f);
//     }
// }
// //document.getElementsByClassName('inputfile').addEventListener('change', handleFileSelect, false);
// var elements = document.getElementsByClassName("inputfile");
// Array.from(elements).forEach(function(element) {
//     element.addEventListener('change', handleFileSelect, false);
// });



var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
    var label	 = input.nextElementSibling,
        labelVal = label.innerHTML;

    input.addEventListener( 'change', function( evt )
    {
        var files = evt.target.files; // FileList object

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    label.style.backgroundImage = "url(" + e.target.result + ")";
                    label.innerHTML = "";
                    // // Render thumbnail.
                    // var span = document.createElement('span');
                    // span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    //     '" title="', escape(theFile.name), '"/>'].join('');
                    // document.getElementById('list').insertBefore(span, null);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    });
});
