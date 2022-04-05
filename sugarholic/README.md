# 🍭 Sugarholic Resort & Spa
May 2021

### My very first creation

Sugarholic is a website of an imaginary resort, with the front-end features developed using HTML, CSS, and vanilla JavaScript. It contains


## Key Features
#### HTML / CSS Design
* Colour schemes:   
  Text: #000000, #333333, #777777, #FFFFFF.  
  Background: #FF5883, #FF91AD, #FEC9D7, #B9EEE1, #79D38E, #39B89A
* Typography:   
  Font (uniform): [font-family: "Bitter", serif;] from Google fonts 
* Hierarchy:   
  h1 - Main title text (one per page)   
  h2 – Sub-title for content section of a page, popup page title h3 – Other lower-level sub-titles, popup page sub-title   
  p/span – General text   
* Buttons & Links:   
  Buttons and links with high importance generally designed to be emphasized by change of background colour and increase in font-weight when hovered.
* Engagement with target audience:   
  The pastel toned pink & green colour theme provides a subtly vibrant mood to the users. Our target group are young people looking for a fun and relaxing vacation and the images and colours are chosen to deliver a low-key exciting tropical vibe. General layout is kept rather classic so that parents of under aged younger target users are comfortable to interact with.
* Responsive design:   
  My website is desktop-first designed, but this does not mean it mainly targets desktop users. Applying media queries (mostly for max-width 768px for tablet device users), layouts and contents differ. Also, I wrote most contents under a wrapper class section so that the content width can always be 100% with max- width: 1024px. Overall layout of the website is not complicated, so I decided there wouldn’t be a need for different tablet and mobile design.


#### JavaScript Features
* Slider on main page   
  * Slider is designed to slide automatically in a slow pace so that users do not have to click the next button themselves. This would be especially convenient for mobile device users since the screen size is not big enough to effectively hold ‘previous’ and ‘next’ button.
  * Auto slide interval is set to 4 seconds per slide to allow users to read the text written on the image. For devices smaller than width of 768px (tablets), the previous and next button is not displayed.
* Header submenu drop down   
  * Submenus are designed to drop down from the main menu when the user hovers (mouseover) on the main menu box. This is done by toggling an .open class on ‘mouseover’ and ‘mouseout’ function on JavaScript.
  * On hover on a specific submenu, the background of it transitions in color to highlight the location. This is a more simple change of CSS code, so it is done by the :hover code on CSS.
  * For devices smaller than width of 768px (tablets), submenus are omitted.
* Header main menu for smaller devices    
  * For devices smaller than width of 768px (tablets), gnb main menu on the header section is hidden under a hamburger icon.
  * On click of the icon, the screen will be fully covered with a simple menu without sub menus.
  * The hamburger icon will change into a close button when the mobile menu is activated. The hamburger icon is made of 3 span codes with a certain width and height with a black background, and two spans transitions into a close button with CSS codes.
  * JavaScript is used to add a class when the hamburger icon is clicked. ‘active’ class will show the mobile menu, and tags with ‘block’ class added will be displayed to none.

<img src="https://user-images.githubusercontent.com/70437869/161388488-1e5914e5-d112-4fa3-8e29-af74acc07f66.png" width="450" height="auto"/>
