<div id="content">
    <table  border="1" align="center">
        <tr><th align="center">Facebook ID</th>
            <th align="center">Username</th>
            <th align="center">First Name</th>
            <th align="center">Middle Name</th>
            <th align="center">Last Name</th>
            <th align="center">Gender</th>
            <th align="center">Birthday</th>
            <th align="center">Location</th>
            <th align="center">Email</th>
            <th align="center">Link</th>
            <th align="center">Religion</th>
            <th align="center">Education</th>
            <th align="center">Work</th>
            <th align="center">Interest</th>
            <th align="center">Device</th>
            <th align="center">Last Update</th>
        </tr>
        <tr>
            <td><?php echo $list->id ?></td>
            <td><?php echo $list->username ?></td>
            <td><?php echo $list->firstName ?></td>
            <td><?php echo $list->middleName ?></td>
            <td><?php echo $list->LastName ?></td>
            <td><?php echo $list->gender ?></td>
            <td><?php echo $list->birthday ?></td>
            <td><?php echo $list->location ?></td>
            <td><?php echo $list->email ?></td>
            <td><?php echo $list->link ?></td>
            <td><?php echo $list->religion ?></td>
            <td><?php echo $list->education ?></td>
            <td><?php echo $list->work ?></td>
            <td><?php echo $list->interest ?></td>
            <td><?php echo $list->devices ?></td>
            <td><?php echo $list->lastUpdate ?></td>
        </tr>
    </table>
    <p><a href="delete=<?php echo $list->id ?>" onclick="{
                if (confirm('Delete This Record?')) {
                    parent.sub_frame.location = 'about:blank';
                    parent.main_frame.location = 'delete=<?php echo $list->id ?>'
                }
                return false;
            }">Delete This Record</a></p>
</div>