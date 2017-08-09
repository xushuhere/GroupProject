/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  shuxu
 * Created: Apr 21, 2016
 */
INSERT INTO `CLERKS` (`Login`, `Password`, `FirstName`, `LastName`) VALUES
('JSmith', '123456', 'John', 'Smith'),
('KAndrew', '123456', 'Kate', 'Andrew'),
('TCasy', '123456', 'Tom', 'Casy');


INSERT INTO `CONTAIN` (`RID`, `TID`) VALUES
('3223979402', '53454'),
('3223979402', '73281'),
('5480753761', '53454'),
('6423919401', '12462'),
('6423919401', '73281');



INSERT INTO `CUSTOMERS` (`Email`, `Password`, `FirstName`, `LastName`, `CountryCodeW`, `LocalNumW`, `CountryCodeH`, `LocalNumH`, `Address`) VALUES
('abc@gt.edu', 'password', 'Andy', 'Chase', '+1', '6152345678', '+1', '6159876543', '7001 Haring Rd, RedCity GA 34568'),
('bcd@gt.edu', 'password', 'Becky', 'Daisy', '+1', '3214879345', '+1', '3249874541', '3731 Aiding St, BlueCity GA 34531'),
('cde@gt.edu', 'password', 'Chris', 'Edison', '+1', '3217879358', '+1', '3249974343', '512 12th St, WhiteCity GA 34521'),
('dfg@gt.edu', 'password', 'Dan', 'Goodman', '+1', '3458888778', '+1', '3458888778', '113 11th St, WhiteCity GA 34521'),
('edf@gt.edu', 'password', 'Edward', 'Flint', '+1', '6152335671', '+1', '6159874542', '123 Boring Ct, RedCity GA 34567'),
('xyz@gt.edu', 'password', 'Xiaohua', 'Zhang', '1', '2323452565', '1', '34567896', '3375 Airport Rd, Chinatown GA 36421');



INSERT INTO `POWER_TOOLS_ACCES` (`ToolID`, `Accessories`) VALUES
('73281', 'Power Code');


INSERT INTO `RESERVATIONS` (`ResID`, `ClerkPickUp`, `ClerkDropOff`, `CuEmail`, `ResStartDate`, `ResEndDate`, `CreditCardNo`, `ExpDate`) VALUES
('3223979402', NULL, NULL, 'bcd@gt.edu', '2016-04-25', '2016-06-25', NULL, NULL),
('5480753761', 'TCasy', 'JSmith', 'dfg@gt.edu', '2016-03-01', '2016-03-03', '3123454320983432', '2016-12-31'),
('6423919401', NULL, NULL, 'xyz@gt.edu', '2016-05-01', '2016-05-03', NULL, NULL),
('922640995', 'KAndrew', NULL, 'dfg@gt.edu', '2016-04-18', '2016-04-29', '4532123487659875', '2018-10-31');



INSERT INTO `SERVICE_REQUEST` (`Clerk`, `TID`, `StartDate`, `EndDate`, `EstCost`) VALUES
('JSmith', '64532', '2016-01-07', '2016-01-16', '12.00'),
('TCasy', '64532', '2016-04-17', '2016-05-16', '12.00');


INSERT INTO `TOOLS` (`ToolID`, `ClerkSellTool`, `AbbrDes`, `FullDes`, `PurchasePrice`, `RentPrice`, `Deposit`, `ToolType`) VALUES
('12462', NULL, 'Tool3', 'A construction tool for handyman', '249.49', '15.49', '250.00', 'construction'),
('52963', 'JSmith', 'Tool4', 'A demo Tool4 sold', '125.00', '2.50', '125.00', 'hand'),
('53454', NULL, 'Tool1', 'A handy tool for handyman', '99.49', '2.49', '100.00', 'hand'),
('64532', NULL, 'Tool5', 'A demo tool has been repaired twice', '89.00', '2.00', '89.00', 'construction'),
('73281', NULL, 'Tool2', 'A power tool for handyman', '149.49', '5.49', '500.00', 'power');

