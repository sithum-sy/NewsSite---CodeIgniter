   <div class="content">
       <div class="main-content">
           <!-- Navigation Bar -->
           <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
               <div class="container-fluid">
                   <a class="navbar-brand" href="<?php echo site_url('home'); ?>">NewsSite</a>
                   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                       aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                       <span class="navbar-toggler-icon"></span>
                   </button>
                   <div class="collapse navbar-collapse" id="navbarNav">
                       <ul class="navbar-nav ms-auto">
                           <li class="nav-item">
                               <a class="nav-link" href="<?php echo site_url('home'); ?>">Home</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="#">World</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="#">Business</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="#">Technology</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="#">Sports</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="<?php echo site_url('about'); ?>">About</a>
                           </li>
                       </ul>
                   </div>
               </div>
           </nav>

           <!-- Main Content Section -->
           <div class="container my-5">
               <div class="row">
                   <div class="col-md-8 offset-md-2">
                       <h2 class="text-center"><?php echo $title; ?></h2>

                       <!-- Display Validation Errors -->
                       <?php echo validation_errors(); ?>

                       <!-- News Form -->
                       <?php echo form_open('news/create'); ?>
                       <div class="mb-3">
                           <label for="title" class="form-label">Title</label>
                           <input type="text" name="title" id="title" class="form-control" required>
                       </div>

                       <div class="mb-3">
                           <label for="text" class="form-label">Text</label>
                           <textarea name="text" id="text" class="form-control" rows="6" required></textarea>
                       </div>

                       <div class="mb-3 text-center">
                           <input type="submit" value="Create news item" name="submit" class="btn btn-primary">
                       </div>
                       </form>
                   </div>
               </div>
           </div>

       </div>