# coursegames

Course Gamification Tools for Blackboard Learn

Introduction

Gamification: “the use of game mechanics and experience design to digitally engage and motivate people to achieve their goals” (Burke, 2014).

This LTI and REST application will allow instructors to create a web link to display their class in gamefully designed tools.  A progress graph, or leaderboard, will show all students and their current progress in course points.  This data is mined in real-time from the Blackboard Grade Center through REST API.  When students view the graph all names are randomized with the exception of their own.  The embedded tools allow for deeper analysis of the data and simulations.
Installation instructions for Blackboard Administrators

    Ensure your Blackboard Learn system has REST API enabled.
    Navigate to SysAdmin -> REST API Integrations
    Create Integration with Application ID:
    0adae04c-04de-43d4-8650-76bb16f44701
    Create or select an existing user with access to all course gradebooks.
    Navigate to SysAdmin -> Building Blocks -> LTI Tool Providers
    Select Register Provider Domain
    Provider Domain: apps.dataii.com
    Tool Provider Key: f13-0683-4c5b-9ee0-2303c978adbb
    Tool Provider Secret: hkeGpcHgsxWGP8v1CiRyWqj9pGV

Directions for Instructors

    Navigate to your course
    Select Build Content -> Web Link
    Name:
    URL: https://apps.dataii.com/bb/coursegames/?analysis=true
    Make sure to select "This link is to a Tool Provider." This will only work after the above steps are completed by the Blackboard Administrator.

For The Nerds

Always read the footnotes and the research behind the solution.

Notes:

An LTI Tool Provider is a 3rd party tool that implements the LTI protocol. LTI provides the seamless integration of externally hosted web-based Learning Tools. If the LTI Tool Provider is already configured, links can be created to the available Tool Providers. If you have been in contact with the Tool Provider directly, a key, secret, or a block of configuration XML may have been supplied which can now be entered.

REST API.  Representational state transfer (REST) or RESTful Web services are one way of providing interoperability between computer systems on the Internet. REST-compliant Web services allow requesting systems to access and manipulate textual representations of Web resources using a uniform and predefined set of stateless operations. Other forms of Web service exist, which expose their own arbitrary sets of operations such as WSDL and SOAP.

Instructors can display the current progress without the analysis buttons by removing "?analysis=true" from the URL:

    URL: https://apps.dataii.com/bb/coursegames/

More about this software: https://szymonmachajewski.wordpress.com/?p=843course-gamification-tools-for-blackboard-learn-the-rest-of-the-story

YouTube video: https://www.youtube.com/watch?v=tntUxfwo2rw

Blackboard Community space: https://community.blackboard.com/groups/hackboard/projects/course-gamification-tools-for-blackboard-learn
