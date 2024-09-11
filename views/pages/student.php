<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 class="main-title">This is the view page: student</h1>
    <div>
        <form action="<?=controller('Student/addStudent')?>" method="post">
            <div class="row">
                <input type="text" name="fullname" placeholder="Enter fullname.">
            </div>
            <div class="row">
                <input type="text" name="course" placeholder="Enter course.">
            </div>
            <div class="row">
                <button type="submit">SAVE</button>
            </div>
        </form>
    </div>
</body>
</html>


<style>
    .main-title{
        color:red;
    }
    .row{
        padding: 5px;
    }
</style>