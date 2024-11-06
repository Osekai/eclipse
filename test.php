<?php
$app = "rankings";

$_SERVER['DOCUMENT_ROOT'] = "/var/www/fastuser/data/www/osekai.net";
include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");

    font();
    css();

        fontawesome();

        notification_system();
        
    tippy();

    medal_popup_v2();
echo "hi";

?>
what

<body>
    <div id="oBeatmapInput"></div>

    <?php navbar(); ?>
    <div class="osekai__panel-container">

        <!-- <HOME V2> -->

        <div class="osekai__home-2col" id="home">
            <div class="osekai__home-2col-col1">
                <?php print_home_panel(); ?>

                <div class="osekai__panel">
                    <div class="osekai__panel-header">
                        <p><?= GetStringRaw("rankings", "home.addUser.title"); ?></p>
                    </div>
                    <div class="osekai__panel-inner">
                        <?php if (loggedin()) { ?>
                            <p><?= GetStringRaw("rankings", "home.addUser.loggedIn"); ?></p>
                        <?php } else { ?>
                            <p><?= GetStringRaw("rankings", "home.addUser.loggedOut"); ?></p>
                        <?php } ?>

                        <div class="rankings__add">
                            <p><?= GetStringRaw("rankings", "home.addUser.addAnotherUser.title"); ?></p>

                            <?php if (loggedin()) { ?>
                                <div class="rankings__add-row">
                                    <input class="osekai__input" type="text" placeholder="<?= GetStringRaw("rankings", "home.addUser.addAnotherUser.placeholder"); ?>" id="osekai__input-id">
                                    <div class="osekai__button" id="osekai__button-add"><?= GetStringRaw("rankings", "home.addUser.addAnotherUser.button"); ?></div>
                                </div>
                            <?php } else { ?>
                                <p><?= GetStringRaw("rankings", "home.addUser.addAnotherUser.loggedOut"); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="osekai__panel">
                    <div class="osekai__panel-header">
                        <p>Tasks</p>
                    </div>
                    <div class="osekai__panel-inner">
                        <p class="rankings__tasks-header" id="currenttask-text"><?= GetStringRaw("rankings", "tasks.current"); ?></p>
                        <div class="rankings__task rankings__task-working rankings__task-current" id="currenttask">
                            <div class="rankings__task-accent">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="rankings__task-content">
                                <div class="rankings__task-content-inner">
                                    <div class="rankings__task-text">
                                        <div class="rankings__task-text-left">
                                            <h3><?= GetStringRaw("rankings", "tasks.task.task"); ?></h3>
                                            <h2 id="currenttask_statustext"><?= GetStringRaw("rankings", "tasks.task.updating"); ?></h2>
                                        </div>
                                        <div class="rankings__task-text-right">
                                            <h3 id="currenttask_status"><strong>50%</strong> - 9000/15000</h3>
                                            <h2 id="currenttask_eta">1:29:00 <light>ETA</light></h2>
                                        </div>
                                    </div>
                                    <div class="osekai__progress-bar">
                                        <div id="currenttask_progress" class="osekai__progress-bar-inner" style="width: 50%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="rankings__tasks-header"><?= GetStringRaw("rankings", "tasks.completed"); ?></p>
                        <div id="completedtasks_list" style="width: 100%;">

                        </div>
                    </div>
                </div>
            </div>
            <div class="osekai__home-2col-col2">
                <div class="rankings__home-v2-header medals-v2">
                    <h1><?= GetStringRaw("rankings", "general.medals.title"); ?></h1>
                </div>
                <div class="rankings__home-v2-button-container">
                    <div class="rankings__home-v2-button" selector="home__button" app="appUsers">
                        <h1><?= GetStringRaw("rankings", "general.medals.title"); ?> / <strong><?= GetStringRaw("rankings", "general.medals.users"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.medals.users.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="appRarity">
                        <h1><?= GetStringRaw("rankings", "general.medals.title"); ?> / <strong><?= GetStringRaw("rankings", "general.medals.rarity"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.medals.rarity.subheader"); ?></p>
                    </div>
                </div>
                <div class="rankings__home-v2-header allmode-v2">
                    <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?></h1>
                </div>
                <div class="rankings__home-v2-button-container">
                <div class="rankings__home-v2-button" selector="home__button" app="appTPP">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.total"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.total.subheader"); ?></p>
                    </div>

                    <div class="rankings__home-v2-button" selector="home__button" app="appStdev">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.standardDeviation"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.standardDeviation.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="appTotalLevel">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.totalLevel"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.totalLevel.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="apStdevLevel">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.standardDeviatedLevel"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.standardDeviatedLevel.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="appTotalAcc">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.totalAccuracy"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.totalAccuracy.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="appStdevAcc">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.standardDeviatedAccuracy"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.standardDeviatedAccuracy.subheader"); ?></p>
                    </div>

                    <div class="rankings__home-v2-button" selector="home__button" app="appReplays">
                        <h1><?= GetStringRaw("rankings", "general.allmode.title"); ?> / <strong><?= GetStringRaw("rankings", "general.allmode.replays"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.allmode.replays.subheader"); ?></p>
                    </div>
                </div>
                <div class="rankings__home-v2-header mappers-v2">
                    <h1><?= GetStringRaw("rankings", "general.mappers.title"); ?></h1>
                </div>
                <div class="rankings__home-v2-button-container">
                    <div class="rankings__home-v2-button" selector="home__button" app="appRanked">
                        <h1><?= GetStringRaw("rankings", "general.mappers.title"); ?> / <strong><?= GetStringRaw("rankings", "general.mappers.ranked"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.mappers.ranked.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="appLoved">
                        <h1><?= GetStringRaw("rankings", "general.mappers.title"); ?> / <strong><?= GetStringRaw("rankings", "general.mappers.loved"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.mappers.loved.subheader"); ?></p>
                    </div>
                    <div class="rankings__home-v2-button" selector="home__button" app="appSubscribers">
                        <h1><?= GetStringRaw("rankings", "general.mappers.title"); ?> / <strong><?= GetStringRaw("rankings", "general.mappers.subscribers"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.mappers.subscribers.subheader"); ?></p>
                    </div>

                    <div class="rankings__home-v2-button" selector="home__button" app="appKudosu">
                        <h1><?= GetStringRaw("rankings", "general.mappers.title"); ?> / <strong><?= GetStringRaw("rankings", "general.mappers.kudosu"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.mappers.kudosu.subheader"); ?></p>
                    </div>
                </div>
                <div class="rankings__home-v2-header badges-v2">
                    <h1><?= GetStringRaw("rankings", "general.badges.title"); ?></h1>
                </div>
                <div class="rankings__home-v2-button-container">
                    <div class="rankings__home-v2-button" selector="home__button" app="appBadges">
                        <h1><?= GetStringRaw("rankings", "general.badges.title"); ?> / <strong><?= GetStringRaw("rankings", "general.badges.title"); ?></strong></h1>
                        <p><?= GetStringRaw("rankings", "general.badges.title"); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- </HOME V2> -->



        <div class="osekai__1col-panels" id="mobile">
            <section class="osekai__panel">
                <div class="osekai__panel-header">
                    <div class="osekai__panel-breadcrumb">
                        <p class="osekai__panel-bc_inactive" selector="breadcrumb"></p>
                        <p class="osekai__panel-bc_active" selector="subcrumb"></p>
                    </div>
                </div>
                <div class="osekai__mobile__panel-section osekai__mp-75">
                    <div class="rankings__nav-options" selector="apps">
                    </div>
                </div>
                <div class="osekai__mobile__panel-section osekai__mp-50">
                    <div class="osekai__panel-hwb-left rankings__nav-options" selector="typecrumb">
                    </div>
                </div>
                <div class="osekai__panel-inner">
                    <div class="osekai__pagination" selector="pagelist">
                    </div>
                    <div class="osekai__pagination-prevnextbuttons">
                        <div class="osekai__pagination-nb-button" selector="button__prev__page">
                            <i class="fas fa-chevron-left" aria-hidden="true"></i>
                            <p><?= GetStringRaw("rankings", "pagination.previous"); ?></p>
                        </div>
                        <div class="osekai__pagination-nb-button osekai__pagination-nb-next-button" selector="button__next__page">
                            <p><?= GetStringRaw("rankings", "pagination.next"); ?></p>
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="osekai__divider"></div>

                    <div class="osekai__mobile__dropdown-search-split">
                        <div class="osekai__mobile-dss-dropdown osekai__dropdown-opener" selector="dropdown__filters">
                            <p class="osekai__mobile-dss-text" selector="filter__activeItem">Username</p>
                            <i class="fas fa-chevron-down osekai__mobile-dss-icon" aria-hidden="true"></i>
                            <div class="osekai__dropdown osekai__dropdown-middle" selector="filter__items">
                            </div>
                        </div>
                        <div class="osekai__mobile-dss-search">
                            <i class="fas fa-search osekai__mobile-dss-icon" aria-hidden="true"></i>
                            <input selector="search__input" type="text" placeholder="<?= GetStringRaw("rankings", "search.placeholder"); ?>" maxlength="40">
                        </div>
                    </div>

                    <div class="osekai__divider"></div>

                    <div class="rankings__inner" selector="rankings__main">
                        <!-- <div class="rankings__mobile-area">
                            <div class="rankings__mobile__bar col90ab">
                                <div class="rankings__mobile__top-bar">
                                    <p>#1</p>
                                    <p>xxluizxx47</p>

                                    <div class="osekai__left osekai__center-flex-row">
                                        <p><span class="strong">50</span> medals</p>
                                        <i class="fas fa-angle-down snapshots__mobile__info snapshots__mobile__info-closed"></i>
                                    </div>
                                </div>

                                <div class="rankings__mobile__bottom-content">
                                    <div class="osekai__flex_row rankings__mobile__header">
                                        <p><span class="light">medal</span> <span class="strong">completion</span></p>

                                        <p class="osekai__left">69%</p>
                                    </div>
                                    <div class="rankings__pb-bar">
                                        <div class="rankings__pb-innerbar" style="width: 69%;">

                                        </div>
                                    </div>

                                    <div class="osekai__flex_row rankings__mobile__header">
                                        <p><span class="strong">rarest</span> <span class="light">medal</span></p>
                                    </div>
                                    <p><span class="rankings__mobile__inline-medal"><img src="https://assets.ppy.sh/medals/web/all-secret-jackpot.png"></span><span class="strong">Mappers' Guild Pack IX</span></p>

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </section>
        </div>
        <div class="osekai__1col-panels" id="desktop">
            <section class="osekai__panel">
                <div class="osekai__panel-header-with-buttons">
                    <div class="osekai__panel-hwb-left">
                        <div class="osekai__panel-breadcrumb">
                            <p class="osekai__panel-bc_inactive" selector="breadcrumb"></p>
                            <p class="osekai__panel-bc_active" selector="subcrumb"></p>
                        </div>
                    </div>
                    <div class="osekai__panel-hwb-right rankings__nav-options" selector="apps">
                    </div>
                </div>
                <div class="osekai__panel-nav osekai__panel-nav__lrcont">
                    <div class="osekai__panel-hwb-left rankings__nav-options" selector="typecrumb">
                    </div>
                    <div class="osekai__panel-hwb-center">
                        <div class="osekai__pagination">
                            <div class="osekai__pagination-nb-button" id="button__prev__page" selector="button__prev__page">
                                <i class="fas fa-chevron-left"></i>
                                <p><?= GetStringRaw("rankings", "pagination.previous"); ?></p>
                            </div>
                            <div class="osekai__pagination-nb-button" id="button__next__page" selector="button__next__page">
                                <p><?= GetStringRaw("rankings", "pagination.next"); ?></p>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="osekai__panel-hwb-right">
                        <div class="osekai__panel-header-button osekai__dropdown-opener" selector="dropdown__filters">
                            <p class="osekai__panel-header-dropdown-text" selector="filter__activeItem"></p>
                            <i class="fas fa-chevron-down osekai__panel-header-dropdown-icon"></i>
                            <div class="osekai__dropdown osekai__dropdown-middle osekai__dropdown osekai__dropdown-middle-hidden" selector="filter__items">
                            </div>
                        </div>
                        <div class="osekai__panel-header-input">
                            <i class="fas fa-search osekai__panel-header-button-icon" aria-hidden="true"></i>
                            <p class="osekai__panel-header-button-text">
                                <label class="osekai__panel-header-input__sizer">
                                    <input selector="search__input" type="text" size="12" placeholder="<?= GetStringRaw("rankings", "search.placeholder"); ?>" maxlength="40">
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="osekai__panel-inner rankings__inner" selector="rankings__main">
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript" src="./js/functions.js?v=<?= OSEKAI_VERSION ?>"></script>
</body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/global/php/functionsEnd.php"); ?>