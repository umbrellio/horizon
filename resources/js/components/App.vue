<script type="text/ecmascript-6">
    export default {
        props: [
            'appName', 'assetsAreCurrent', 'isDownForMaintenance'
        ],
    }
</script>

<template>
    <div>
        <alert :message="alert.message"
            :type="alert.type"
            :auto-close="alert.autoClose"
            :confirmation-proceed="alert.confirmationProceed"
            :confirmation-cancel="alert.confirmationCancel"
            v-if="alert.type"></alert>

        <div class="container mb-5">
            <div class="d-flex align-items-center py-4 header">
                <svg class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <path class="fill-primary" d="M5.26176342 26.4094389C2.04147988 23.6582233 0 19.5675182 0 15c0-4.1421356 1.67893219-7.89213562 4.39339828-10.60660172C7.10786438 1.67893219 10.8578644 0 15 0c8.2842712 0 15 6.71572875 15 15 0 8.2842712-6.7157288 15-15 15-3.716753 0-7.11777662-1.3517984-9.73823658-3.5905611zM4.03811305 15.9222506C5.70084247 14.4569342 6.87195416 12.5 10 12.5c5 0 5 5 10 5 3.1280454 0 4.2991572-1.9569336 5.961887-3.4222502C25.4934253 8.43417206 20.7645408 4 15 4 8.92486775 4 4 8.92486775 4 15c0 .3105915.01287248.6181765.03811305.9222506z"/>
                </svg>

                <h4 class="mb-0 ml-2">
                    <strong>Laravel</strong> Horizon{{ appName }}</h4>

                <button class="btn btn-outline-primary ml-auto" :class="{active: autoLoadsNewEntries}" v-on:click.prevent="autoLoadNewEntries" title="Auto Load Entries">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="icon fill-primary">
                        <path d="M10 3v2a5 5 0 0 0-3.54 8.54l-1.41 1.41A7 7 0 0 1 10 3zm4.95 2.05A7 7 0 0 1 10 17v-2a5 5 0 0 0 3.54-8.54l1.41-1.41zM10 20l-4-4 4-4v8zm0-12V0l4 4-4 4z"></path>
                    </svg>
                </button>
            </div>

            <div class="row mt-4">
                <div class="col-2 sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <router-link active-class="active" to="/dashboard" class="nav-link d-flex align-items-center pt-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M0 3c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm2 2v12h16V5H2zm8 3l4 5H6l4-5z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/monitoring" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                                </svg>
                                <span>Monitoring</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/metrics" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M1 10h3v10H1V10zM6 0h3v20H6V0zm5 8h3v12h-3V8zm5-4h3v16h-3V4z"></path>
                                </svg>
                                <span>Metrics</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/statistics" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.9 511.9">
                                    <path d="M460.8 25.55c-28.2-.1-51.1 22.8-51.2 51 0 13.3 5.1 26.1 14.4 35.6l-93.5 187.1c-2-.3-4.1-.6-6.2-.6a51.07 51.07 0 0 0-19.3 3.8l-72.6-81.7c4.2-7.5 6.5-15.9 6.6-24.6 0-28.3-22.9-51.2-51.2-51.2s-51.2 22.9-51.2 51.2c.1 12.2 4.5 24 12.6 33.2l-88.9 155.5c-3-.6-6.1-.9-9.1-.9-28.3 0-51.2 22.9-51.2 51.2s22.9 51.2 51.2 51.2 51.2-22.9 51.2-51.2c-.1-12.2-4.5-24-12.6-33.2l88.8-155.5c9.5 1.9 19.4.9 28.3-2.9l72.6 81.7c-4.2 7.5-6.4 16-6.5 24.6-.1 28.3 22.8 51.3 51 51.4 28.3.1 51.3-22.8 51.4-51 0-13.3-5.1-26.2-14.4-35.8l93.5-187.1c2 .3 4.1.6 6.2.6 28.3 0 51.2-22.9 51.2-51.2s-22.8-51.2-51.1-51.2z"/>
                                </svg>
                                <span>Statistics</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/batches" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M1 1h18v2H1V1zm0 8h18v2H1V9zm0 8h18v2H1v-2zM1 5h18v2H1V5zm0 8h18v2H1v-2z"/>
                                </svg>
                                <span>Batches</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/jobs/pending" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM7 6h2v8H7V6zm4 0h2v8h-2V6z"/>
                                </svg>
                                <span>Pending Jobs</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/jobs/completed" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"></path>
                                </svg>
                                <span>Completed Jobs</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/failed" class="nav-link d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"></path>
                                </svg>
                                <span>Failed Jobs</span>
                            </router-link>
                        </li>
                    </ul>
                </div>

                <div class="col-10">
                    <div v-if="!assetsAreCurrent" class="alert alert-warning">
                        The published Horizon assets are not up-to-date with the installed version. To update, run:<br/><code>php artisan horizon:publish</code>
                    </div>

                    <div v-if="isDownForMaintenance" class="alert alert-warning">
                        This application is in "maintenance mode". Queued jobs may not be processed unless your worker is using the "force" flag.
                    </div>

                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
