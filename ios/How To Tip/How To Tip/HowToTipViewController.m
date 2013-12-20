//
//  HowToTipViewController.m
//  How To Tip
//
//  Created by Tony Tam on 12/19/13.
//  Copyright (c) 2013 us.ca.sanfrancisco.tam.tony. All rights reserved.
//

#import "HowToTipViewController.h"

@interface HowToTipViewController ()

@end

@implementation HowToTipViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)tipButtonPushed:(id)sender {
    // NSLog(@"Button %ld clicked.", (long int)[sender tag]);
    // NSLog(@"Text is %@", _textFieldTotalBill.text);
    
    float tip = 0.0;
    float percent = 15;
    if (sender == _normalTipButton) {
        percent = 15;
    }
    if (sender == _cheapTipButton) {
        percent = 10;
    }
    if (sender == _generousTipButton) {
        percent = 20;
    }
    
    float totalBill = [_textFieldTotalBill.text floatValue];
    tip = percent * 0.01 * totalBill;
    _tipAmount.text = [NSString stringWithFormat:@"%2.2f", tip];
    
    _billPlusTips.text = [NSString stringWithFormat:@"%2.2f", tip + totalBill];

    [_textFieldTotalBill resignFirstResponder];
}

// Validate the text input for a single decimal and also only 2 decimal places
// useful for dollar amounts
-  (BOOL)textField:(UITextField *)textField shouldChangeCharactersInRange:(NSRange)range replacementString:(NSString *)string
{
    NSString *newString = [textField.text stringByReplacingCharactersInRange:range withString:string];
    
    // only allow for one decimal point
    NSArray  *arrayOfString = [newString componentsSeparatedByString:@"."];
    if ([arrayOfString count] > 2 )
        return NO;
    
    
    // Only allow for 2 places after the decimal point
    NSRange decimalLocation = [newString rangeOfString:@"."];
    if (newString.length >= 3 && decimalLocation.location < newString.length - 3) {
        return NO;
    }
    
    return YES;
}

@end
