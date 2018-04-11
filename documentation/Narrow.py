#NR7 + ID
#Buy with NR7, Sell with NR7ID
#Narrow Range 7 - When a trading day range is more narrow than any
#of the previous six days.
#inside Day - Current High < Prev High && Current Low > Prev Low

Narrow = (7,8,5,4,3,2,1)
PrevLow = 5
PrevHigh = 10
CurrentLow = 7
CurrentHigh = 12
CurrentClose = 12

RSI = 'Hold'
Heikin = 'Buy'
NR7 = 'Buy'
NR7ID = 'Sell'
FD = ''

##Narrow Range logic
if Narrow[6] < (Narrow[5] and Narrow[4] and Narrow[3] and Narrow[2] and Narrow[1] and Narrow[0]):
    if CurrentClose > PrevHigh: #NR7
        NarrowD = 'Buy'
    elif CurrentHigh < PrevHigh and CurrentLow > PrevLow: #NR7ID
        NarrowD = 'Sell'
    else:
        NarrowD = 'Hold'


##FinalDecision
#Buy first then sell?!?
if RSI == 'Buy':
    FD == 'Buy'
elif Heikin == 'Buy':
    FD == 'Buy'
elif NR7 == 'Buy':
    FD == 'Buy'
else:
    if RSI == 'Sell':
        FD == 'Sell'
    elif NR7ID == 'Sell':
        FD == 'Sell'
    elif Heikin == 'Sell':
        FD == 'Sell'
    else:
        FD == 'Hold'


#Or like this !?
if RSI == 'Buy':
    FD = 'Buy'
elif RSI == 'Sell':
    FD = 'Sell'
else:
    if Heikin == 'Buy':
        FD = 'Buy'
    elif NR7ID == 'Sell':
        FD = 'Sell'
    else:
        if NR7 == 'Buy':
            FD = 'Buy'
        elif Heikin == 'Sell':
            FD = 'Sell'
        else:
            FD = 'Hold'
        
        
        
print(Narrow)
