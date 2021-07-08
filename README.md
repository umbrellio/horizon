## Introduction

This fork adds:
- a search box to the pending jobs page, that allows to filter pending jobs by name
- input for datetime to the pending jobs page, that allows to filter pending jobs by created at (from/to)
![image](https://user-images.githubusercontent.com/34129120/120107147-852cd700-c168-11eb-9281-2b21225c436c.png)
- new page "Statistics", which has 3 tabs for each type of jobs (Pending, Completed, Failed). On each tab could be seen, how many jobs are in each status
![image](https://user-images.githubusercontent.com/34129120/120106852-5b26e500-c167-11eb-9821-3bdad9e16f9e.png)
- possibility to remove jobs from pending
![image](https://user-images.githubusercontent.com/34129120/120107312-477c7e00-c169-11eb-9f67-84b334ba8315.png)

## Description

**Search** 

When job pushed to "pending" in ```RedisJobRepository::pushed```, it also create an index for this job. It means that id of job is stored in general ```pending_jobs``` key and also in separate ```pending_jobs:index:name_of_job``` key. ```index``` could be configured in ```config/horizon```. When user try to filter jobs, we could find id of needed jobs easily, because they are all stored in one key.
Removing this keys is arranged same way like ```pending_jobs```. Expires time of this indexes also could be configured in ```config/horizon```.

**Statistics**

Page "Statistics" show how many jobs of each type now exists. For counting this stats we use same keys like in search. Now for each job we have separate key with id's of all job with this name. Just counting number of this ids give us stats.

**Delete jobs**

Now it is possible to delete jobs which are in status "pending". For this feature was added button "Delete" and checkboxes near each job for selecting, which should be removed. Also it could be selected all jobs on page. After button was pressed, ids of selected jobs send to ```PendingJobsController:batchDelete```  and removed from database. Also removed from ```pending_jobs``` key and from ```pending_jobs:index:name_of_job``` key.
