use stud_v17_gruppe1;

CREATE EVENT my_status_event
  ON SCHEDULE
    EVERY 1 DAY
    STARTS '2017-03-14 00:20:00' ON COMPLETION PRESERVE ENABLE
  DO
  BEGIN
    UPDATE project p SET p.Status_id = 'PRGRSS' WHERE p.Status_id = 'ONHOLD' AND p.Start = CURDATE();
    UPDATE task t SET t.Status_id = 'PRGRSS' WHERE t.Status_id = 'ONHOLD' AND t.Start = CURDATE();
  END ;


