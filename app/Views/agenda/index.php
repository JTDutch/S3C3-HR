<div class="container">
  <h2 class="title">Agenda</h2>

  <!-- Tabs for filtering shows -->
  <div class="d-flex justify-content-between align-items-end mb-3">
    <ul class="nav nav-tabs border-bottom border-white" id="agendaTabs" role="tablist" style="flex-grow: 1;">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">
          <h2 class="mb-0">Aankomende Shows</h2>
        </a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="past-tab" data-bs-toggle="tab" href="#past" role="tab" aria-controls="past" aria-selected="false">
          <h2 class="mb-0">Gespeelde Shows</h2>
        </a>
      </li>
    </ul>
    <?php if (session()->get("account_id")): ?>
      <a href="<?= base_url("Admin/add_show") ?>" class="btn btn-warning btn-outline-dark text-white ms-3">
        <i class="fa-solid fa-plus"></i>
      </a>
    <?php endif; ?>
  </div>

  <div class="tab-content" id="agendaTabsContent">
    <!-- Upcoming Shows Tab -->
    <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
      <?php foreach($agenda as $show): ?>
        <?php
          // Check if the show is in the future
          $date = new DateTime($show->show_date);
          $formattedDate = strftime('%A %e %B %Y', $date->getTimestamp());
          $formattedDate = ucfirst($formattedDate); // Capitalize first letter

          // If the show is upcoming, display it in the upcoming tab
          if (new DateTime($show->show_date) > new DateTime()) :
        ?>
          <div class="card mb-3 shadow-sm bg-black" style="color: white;">
            <div class="card-body">
              <div class="row text-center align-items-center">
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                  <h4 class="mb-1 fw-bold"><?= format_dutch_date($show->show_date) ?></h4>
                  <p class="mb-0 fs-5"><?= $show->show_time ?></p>
                </div>
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                  <h4 class="mb-1 fs-3"><?= $show->venue_city ?></h4>
                  <p class="mb-0 fs-5"><?= $show->venue_name ?></p>
                </div>
                <div class="col-12 col-sm-4 d-flex justify-content-center gap-3 flex-wrap">
                  <?php if ($show->ticket_link): ?>
                    <a href="<?= $show->ticket_link ?>" class="btn btn-outline-dark btn-primary text-white fs-5">
                      Tickets
                    </a>
                  <?php endif; ?>
                  <?php if ($show->info_link): ?>
                    <a href="<?= $show->info_link ?>" class="btn btn-outline-dark btn-primary text-white fs-5">
                      Info
                    </a>
                  <?php endif; ?>
                  <?php if (session()->get("account_id")): ?>
                    <a href="<?= base_url("Admin/edit_show/" . $show->id) ?>" class="btn btn-outline-dark btn-warning text-white fs-5">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <!-- Delete Button -->
                    <button class="btn btn-outline-dark btn-danger text-white fs-5 delete-btn" data-id="<?= $show->id ?>">
                      <i class="fa-solid fa-x"></i>
                    </button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <!-- Past Shows Tab -->
    <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
      <?php foreach($agenda as $show): ?>
        <?php
          // If the show is past, display it in the past tab
          if (new DateTime($show->show_date) < new DateTime()) :
        ?>
          <div class="card mb-3 shadow-sm bg-black text-white">
            <div class="card-body">
              <div class="row text-center align-items-center">
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                  <h4 class="mb-1 fw-bold"><?= format_dutch_date($show->show_date) ?></h4>
                  <p class="mb-0 fs-5"><?= $show->show_time ?></p>
                </div>
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                  <h4 class="mb-1 fs-3"><?= $show->venue_city ?></h4>
                  <p class="mb-0 fs-5"><?= $show->venue_name ?></p>
                </div>
                <div class="col-12 col-sm-4 d-flex justify-content-center gap-3 flex-wrap">
                  <?php if ($show->ticket_link): ?>
                    <a href="<?= $show->ticket_link ?>" class="btn btn-outline-dark btn-primary text-white fs-5">
                      Tickets
                    </a>
                  <?php endif; ?>
                  <?php if ($show->info_link): ?>
                    <a href="<?= $show->info_link ?>" class="btn btn-outline-dark btn-primary text-white fs-5">
                      Info
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>