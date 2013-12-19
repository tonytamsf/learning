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
    NSLog(@"Button %ld clicked.", (long int)[sender tag]);
}


@end
