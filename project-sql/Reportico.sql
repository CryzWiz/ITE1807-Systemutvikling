SELECT CONCAT(u.FirstName,' ',u.LastName ) AS FullName,
       task.Name AS TaskName, team.Name AS TeamName, p.Name AS ProjectName,
       TIMESTAMPDIFF(SECOND, t.Start,t.Stop) AS Duration,
  t.Start, t.Stop, task.PlannedHours*3600 As Estimated,
 ps.ProjectSubTotal, ps.ProjectSubEstimated, us.UserSubTotal,
  t.Team_id, t.Task_id, u.id AS UserId, p.id AS ProjectId
FROM timeregistration t
  INNER JOIN team ON (t.Team_id=team.id)
  INNER JOIN user_team ut ON (team.id=ut.Team_id)
  INNER JOIN user u ON (t.User_id=u.id)
  INNER JOIN task ON (task.id=t.Task_id)
  INNER JOIN project p ON (p.id=task.Project_id)
  LEFT JOIN
  (
    SELECT tsk.Project_id, tr.Team_id,
      SUM(TIMESTAMPDIFF(SECOND, tr.Start, tr.Stop)) AS ProjectSubTotal,
      SUM(tsk.PlannedHours*3600) AS ProjectSubEstimated
    FROM timeregistration tr
      INNER JOIN task tsk ON tsk.id = tr.Task_id
    GROUP BY tr.Team_id,tsk.Project_id
  ) ps ON ps.Project_id = p.id AND ps.Team_id = t.Team_id
  LEFT JOIN
  (
    SELECT tsk.Project_id, tr.Team_id, tr.User_id AS uid, SUM(TIMESTAMPDIFF(SECOND, tr.Start, tr.Stop)) AS UserSubTotal
    FROM timeregistration tr
      INNER JOIN task tsk ON tsk.id = tr.Task_id
    GROUP BY tsk.Project_id, tr.Team_id, tr.User_id
  ) us ON us.Project_id = p.id AND ps.Team_id = t.Team_id AND t.User_id = us.uid
WHERE ut.User_id=4 AND ut.isTeamleader = true AND t.Approved=false AND t.Stop IS NOT NULL
ORDER By TeamName, ProjectName, FullName, task.Name