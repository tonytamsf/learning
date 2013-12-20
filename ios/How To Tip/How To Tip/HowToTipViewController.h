//
//  HowToTipViewController.h
//  How To Tip
//
//  Created by Tony Tam on 12/19/13.
//  Copyright (c) 2013 us.ca.sanfrancisco.tam.tony. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface HowToTipViewController : UIViewController
@property (weak, nonatomic) IBOutlet UITextField *textFieldTotalBill;
@property (weak, nonatomic) IBOutlet UIButton *normalTipButton;
@property (weak, nonatomic) IBOutlet UIButton *generousTipButton;
@property (weak, nonatomic) IBOutlet UIButton *cheapTipButton;
@property (weak, nonatomic) IBOutlet UILabel *tipAmount;
@property (weak, nonatomic) IBOutlet UILabel *billPlusTips;

@end
