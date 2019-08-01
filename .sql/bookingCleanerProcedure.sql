# Author: Luca Di Bello

# Create procedure
drop procedure if exists bookingCleaner;

delimiter //
create procedure bookingCleaner()
begin
    # Declare variables
    DECLARE done INT DEFAULT FALSE;
    DECLARE bookDate DATE;
    DECLARE bookTime TIME;
    DECLARE bookId INT;
    DECLARE fullTimestamp TIMESTAMP;
    DECLARE minDiff INT;
    DECLARE roundNow TIMESTAMP;
    
    # Declare cursor and handler
    DECLARE cur CURSOR FOR SELECT date, time, appointment_id FROM oc_booking;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    # Open cursor
    OPEN cur;
    read_loop: LOOP
        # Get next row
        FETCH cur INTO bookDate, bookTime, bookId;

        # Check if the cursor has already iterated through all the file
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        # Convert the date and time in a timestamp
        SET fullTimestamp = TIMESTAMP(bookDate, bookTime);
        
        # Round current time to next half hour
        SET minDiff = (30 - MINUTE(CURRENT_TIME())) % 30 ;

        # Get all old data  
        IF bookDate <= DATE(NOW()) THEN
            
            # Check if the booking timestamp is older then the next half hour
            if fullTimestamp < DATE_ADD(NOW(), INTERVAL minDiff MINUTE) THEN
                # Remove row from database
                DELETE FROM oc_booking WHERE appointment_id = bookId; 
            END IF;
        END IF;
    END LOOP;
    CLOSE cur;
end;
//
delimiter ;

# Create scheduler
DROP EVENT IF EXISTS 30min_cleaner;

DELIMITER //
CREATE DEFINER='root'@'%'
EVENT 30min_cleaner
    ON SCHEDULE
    EVERY 30 MINUTE
    STARTS "2019-06-28 14:35"
    ON COMPLETION PRESERVE
COMMENT "This schedule will clear the oc_booking table every 30 minutes."
DO 
    BEGIN
        SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'Starting booking cleaner'; 
        call bookingCleaner();
        SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'Booking cleaner finished';
    END //
DELIMITER ;