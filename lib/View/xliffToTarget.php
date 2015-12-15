<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>MateCat XLIFF-to-target utility</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/js/lib/dropzone/dropzone.css" />
<style>
    html, body {
        position: relative;
        margin: 0;
        padding: 40px;
        width: 100%;
        height: 100%;
        background: #f0f0f0;
    }
    .dropzone {
        background: #d8d8d8;
        border: none;
        color: #828282;
        border-radius: 30px;
        transition: all .25s;
    }
    body.dropzone.dz-clickable .dz-message {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        margin: 0;
        height: 70px;
        font: 23px/1.7 sans-serif;
        transition: all .25s;
        opacity: 1 !important;
    }
    body.dropzone.dz-clickable.dz-drag-hover {
        color: #828282 !important;
        border: none;
        padding: 30px;
        background: #c0c0c0;
        transform: scale(1.04, 1.04);
    }
    .frame {
        position: absolute;
        top: 12px;
        left: 12px;
        right: 12px;
        bottom: 12px;
        border: dashed 5px #828282;
        border-radius: 30px;
        transition: all .25s;
    }
    .click {
        cursor: pointer !important;
    }
</style>

</head>
<body class="dropzone click" id="myDropzone">

<div class="frame click"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="/public/js/lib/dropzone/dropzone.js"></script>

<script>
    Dropzone.options.myDropzone = {
        url: "/index.php?action=xliffToTarget", // Set the url
        paramName: "xliff", // The name that will be used to transfer the file
        dictDefaultMessage: "Drop your XLIFF files here<br>to obtain the translated documents",
        clickable: '.click',
        //maxFilesize: 2, // MB
        accept: function(file, done) {
            var ext = file.name.split('.').pop().toLowerCase();
            switch (ext) {
                case "xlf":
                case "xliff":
                case "sdlxliff":
                    // Allowed!
                    done();
                    break;
                default:
                    done("This tool supports only XLIFF files!");
            }
        },
        sending: function(file, xhr, formData) {
            xhr.responseType = "blob";
        },
        success: function(file, data) {
            var downloadUrl = URL.createObjectURL(data);
            var a = document.createElement("a");
            a.href = downloadUrl;
            a.download = file.name.substring(0, file.name.lastIndexOf("."));
            document.body.appendChild(a);
            a.click();
        }
    };
</script>

</body>
</html>