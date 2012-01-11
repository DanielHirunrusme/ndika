SET GLOBAL max_sp_recursion_depth = 40;
DROP PROCEDURE IF EXISTS showAllChild;
DROP PROCEDURE IF EXISTS __showAllChild;

DELIMITER $$

CREATE PROCEDURE __showAllChild(parentID INT)
BEGIN
    #Declare variable
    Declare projectListId INT DEFAULT 0;

    #Set variable for loop rows_project_list cursor
    Declare finished int default 0; #Zero mean false or not finished yet

    #Select all child
    Declare rows_project_list CURSOR FOR
        Select id from cms_project_lists WHERE parent_id=parentID;
    
    #To handle finished cursor from loop
    Declare continue handler for not found set finished = 1; #One mean true or finished
    
    #Insert all media depend on this ID(parentID)
    insert ignore into temp_child_project_lists
        select * from cms_project_lists where id=parentID;
    
    #Loop this cursor. This cursor filled with all child of this ID
    OPEN rows_project_list;
    
    get_child_of_child: LOOP
        Fetch rows_project_list into projectListId;
        
        #Recursive state
        #If rows_project_list have child call again. Finished = 0 mean that rows_project_list have some record
        IF finished=0 THEN
            CALL __showAllChild(projectListId);
        ELSE
            Leave get_child_of_child;
        END IF;
    END LOOP get_child_of_child;
    
    CLOSE rows_project_list;
END $$

CREATE PROCEDURE `showAllChild`(parentID INT)
BEGIN
    DROP TABLE IF EXISTS temp_child_project_lists;
    CREATE TABLE IF NOT EXISTS temp_child_project_lists LIKE cms_project_lists;
    
    #CALL __showAllMedia(parentID);
    CALL __showAllChild(parentID);

    #SELECT * FROM temp_child_project_lists;
    
    #DROP TABLE allmedia;
END $$
DELIMITER ;
# MySQL returned an empty result set (i.e. zero rows).
