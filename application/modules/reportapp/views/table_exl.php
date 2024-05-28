<?php 
    
    /************************************************/
    /***********           Visit Query        *************/
    /************************************************/
    
    $patient_info = $this->Visit_model->visit_patient_information($patient_id);
    $visit_info = $this->Visit_model->visit_information($visit_id, $patient_id);
    $visit_general_examinations = $this->Visit_model->visit_general_examinations($visit_id, $patient_id);
    $visit_laboratory_investigations = $this->Visit_model->visit_laboratory_investigations($visit_id, $patient_id);
    $visit_laboratory_ecg = $this->Visit_model->visit_laboratory_ecg($visit_id, $patient_id);
    $visit_complications = $this->Visit_model->visit_complications($visit_id, $patient_id);
    $visit_personal_habits = $this->Visit_model->visit_personal_habits($visit_id, $patient_id);
    $visit_family_history = $this->Visit_model->visit_family_history($visit_id, $patient_id);
    
    
    /************************************************/
    /***********         End  Visit Query        *************/
    /************************************************/
    ?>
      
      <table class="table" border="1">
        <!-- <thead>
          <tr>
            <th class="fixed-side" scope="col">SL</th>
            <th scope="col">Date</th>
            <th scope="col">BNDR ID</th>
            <th scope="col">Organization</th>
            <th scope="col">Center</th>
            <th scope="col">Full Name</th>
            <th scope="col">Mobile Number</th>
            <th scope="col">Marital Status</th>
            <th scope="col">Date Of Birth</th>
            <th scope="col">Age</th>
            <th scope="col">National ID</th>
            <th scope="col">Gender </th>
            <th scope="col">Patient Guide Book No</th>
            <th scope="col">Division</th>
            <th scope="col">District</th>
            <th scope="col">Upazila</th>
            <th scope="col">Address</th>
            <th scope="col">Postal Code</th>
            <th scope="col">Monthly Expenditure</th>
            <th scope="col">Profession</th>
            <th scope="col">Education</th>
            <th scope="col">Payment</th>
            <th scope="col">Registration Date</th>
            <th scope="col">Registration Center</th>
            <th scope="col">Visit Date</th>
            <th scope="col">Visit Center</th>
            <th scope="col">V1 Chewing Tobacco </th>
            <th scope="col">V1 Smoking</th>
            <th scope="col">V1 betel leaf</th>
            <th scope="col">V1 Betel Nut</th>
            <th scope="col">V1 Alcohol</th>
           <th scope="col">V1 Diabetes</th>
           <th scope="col">V1 HTN</th>
           <th scope="col">V1 CAD</th>
           <th scope="col">V1 Stroke</th>
           <th scope="col">V1 Obesity</th>
           <th scope="col">V1 Dyslipidaemia</th>
           <th scope="col">V1 Type Of Glucose Intolerance</th>
           <th scope="col">V1 Duration Of Glucose Intolerance/th>
           <th scope="col">V1 CAD</th>
           <th scope="col">V1 DKA</th>
           <th scope="col">V1 Dyslipidaemia </th>
           <th scope="col">V1 Foot Complications</th>
           <th scope="col">V1 Hypoglycaemia</th>
           <th scope="col">V1 Hypertension</th>
           <th scope="col">V1 Skin Disease</th>
           <th scope="col">V1 Gastro Complications</th>
           <th scope="col">V1 PVD</th>
           <th scope="col">V1 Neuropathy</th>
           <th scope="col">V1 Others</th>
           <th scope="col">V1 Stroke</th>
           <th scope="col">V1 Retinopathy</th>
           <th scope="col">V1 HHS</th>
           <th scope="col">V1 SYMPTOMS AT DIAGNOSIS/th>
           <th scope="col">V1 OTHER COMPLAINTS</th>
           <th scope="col">V1 Height</th>
           <th scope="col">V1 Hip </th>
           <th scope="col">V1 Sitting SBP</th>
           <th scope="col">V1 Standing SBP</th>
           <th scope="col">V1 Weight</th>
           <th scope="col">V1 Waist</th>
           <th scope="col">V1 Sitting DBP</th>
            <th scope="col">Date</th>
            <th scope="col">BNDR ID</th>
            <th scope="col">Organization</th>
            <th scope="col">Center</th>
            <th scope="col">Full Name</th>
            <th scope="col">Mobile Number</th>
            <th scope="col">Marital Status</th>
            <th scope="col">Date Of Birth</th>
            <th scope="col">Age</th>
            <th scope="col">National ID</th>
            <th scope="col">Gender </th>
            <th scope="col">Patient Guide Book No</th>
            <th scope="col">Division</th>
            <th scope="col">District</th>
            <th scope="col">Upazila</th>
            <th scope="col">Address</th>
            <th scope="col">Postal Code</th>
            <th scope="col">Monthly Expenditure</th>
            <th scope="col">Profession</th>
            <th scope="col">Education</th>
            <th scope="col">Payment</th>
            <th scope="col">Registration Date</th>
            <th scope="col">Registration Center</th>
            <th scope="col">Visit Date</th>
            <th scope="col">Visit Center</th>
            <th scope="col">V1 Chewing Tobacco </th>
            <th scope="col">V1 Smoking</th>
            <th scope="col">V1 betel leaf</th>
            <th scope="col">V1 Betel Nut</th>
            <th scope="col">V1 Alcohol</th>
           <th scope="col">V1 Diabetes</th>
           <th scope="col">V1 HTN</th>
           <th scope="col">V1 CAD</th>
           <th scope="col">V1 Stroke</th>
           <th scope="col">V1 Obesity</th>
           <th scope="col">V1 Dyslipidaemia</th>
           <th scope="col">V1 Type Of Glucose Intolerance</th>
           <th scope="col">V1 Duration Of Glucose Intolerance/th>
           <th scope="col">V1 CAD</th>
           <th scope="col">V1 DKA</th>
           <th scope="col">V1 Dyslipidaemia </th>
           <th scope="col">V1 Foot Complications</th>
           <th scope="col">V1 Hypoglycaemia</th>
           <th scope="col">V1 Hypertension</th>
           <th scope="col">V1 Skin Disease</th>
           <th scope="col">V1 Gastro Complications</th>
           <th scope="col">V1 PVD</th>
           <th scope="col">V1 Neuropathy</th>
           <th scope="col">V1 Others</th>
           <th scope="col">V1 Stroke</th>
           <th scope="col">V1 Retinopathy</th>
           <th scope="col">V1 HHS</th>
           <th scope="col">V1 SYMPTOMS AT DIAGNOSIS/th>
           <th scope="col">V1 OTHER COMPLAINTS</th>
           <th scope="col">V1 Height</th>
           <th scope="col">V1 Hip </th>
           <th scope="col">V1 Sitting SBP</th>
           <th scope="col">V1 Standing SBP</th>
           <th scope="col">V1 Weight</th>
           <th scope="col">V1 Waist</th>
           <th scope="col">V1 Sitting DBP</th>
           <th scope="col">V1 OTHER PHYSICAL EXAMINATION</th>
           <th scope="col">V1 Posterior Tribila</th>
           <th scope="col">V1 Arteria Dorsalis Pedis</th>
           <th scope="col">V1 Monofilament</th>
           <th scope="col">V1 Tuning Fork</th>
           <th scope="col">V1 Others</th>
           <th scope="col">V1 Name Of Doctor</th>
           <th scope="col">V1 Rice</th>
           <th scope="col">V1 Ruti/Chapati</th>
           <th scope="col">V1 Fish</th>
           <th scope="col">V1 Meat </th>
           <th scope="col">V1 Milk</th>
           <th scope="col">V1 Egg</th>
           <th scope="col">V1 Sweets</th>
           <th scope="col">V1 Green Vegetables</th>
           <th scope="col">V1 Fast Foods</th>
           <th scope="col">V1 Gee/Butter</th>
           <th scope="col">V1 Soft Drinks</th>
           <th scope="col">V1 Table Salt</th>
           <th scope="col">V1 Restaurant Food</th>
           <th scope="col">V1 Walking</th>
           <th scope="col">V1 Running</th>
           <th scope="col">V1 Cycling</th>
           <th scope="col">V1 Treadmil</th>
           <th scope="col">V1 Swimming</th>
           <th scope="col">V1 Jogging </th>
           <th scope="col">V1 Date</th>
           <th scope="col">V1 Right Eye</th>
           <th scope="col">V1 Left Eye</th>
           <th scope="col">V1 Other</th>
          <th scope="col">V1 Treatment</th>
          <th scope="col">V1 Name Of Doctor</th>
          <th scope="col">V1 FBG</th>
          <th scope="col">V1 2hAG</th>
          <th scope="col">V1 Post-meal BG </th>
          <th scope="col">V1 RBG</th>
          <th scope="col">V1 HbA1c</th>
          <th scope="col">V1 T.Chol</th>
          <th scope="col">V1 LDL-C</th>
          <th scope="col">V1 HDL-C</th>
          <th scope="col">V1 TG</th>
          <th scope="col">V1 ECG</th>
          <th scope="col">V1 USG/th>
          <th scope="col">V1 S.Creatinine</th>
          <th scope="col">V1 SGPT</th>
          <th scope="col">V1 Hb</th>
          <th scope="col">V1 TC</th>
          <th scope="col">V1 DC</th>
          <th scope="col">V1 ESR</th>
          <th scope="col">V1 Urine Albumin</th>
          <th scope="col">V1 Urine micro-Albumin</th>
          <th scope="col">V1 Urine Acetone</th>
          <th scope="col">V1 Blood Group</th>
          <th scope="col">V1 Others</th>
          <th scope="col">V1 OADs</th>
          <th scope="col">V1 Insulin </th>
          <th scope="col">V1 Anti-HTN</th>
          <th scope="col">V1 Anti-lipid</th>
          <th scope="col">V1 Anti-platelet</th>
          <th scope="col">V1 Anti-obesity</th>
          <th scope="col">V1 Others</th>
          <th scope="col">V1 Final Diagnosis</th>
          <th scope="col">V1 Other associated Diseases</th>
          <th scope="col">V1 Date</th>
          <th scope="col">V1 Name Of Doctor</th>
          <th scope="col">V1 Dietary Advice</th>
          <th scope="col">V1 Diet No</th>
          <th scope="col">V1 Physical activity</th>
          <th scope="col">V1 Page No</th>
          <th scope="col">V1 OADs</th>
          <th scope="col">V1 Insulin</th>
          <th scope="col">V1 Anti-HTN</th>
          <th scope="col">V1 Anti-lipid</th>
          <th scope="col">V1 Anti-platelet</th>
          <th scope="col">V1 Anti-obesity</th>
          <th scope="col">V1 Others</th>
          <th scope="col">V1 Next Visit Date</th>
          <th scope="col">V1 Next Investigation</th>
          <th scope="col">V1 Payment</th>
         
          </tr>
        </thead> -->
        <tbody>
          <tr>
          
            
            <td>Cell content longer</td>
            <td><?php echo $patient_info['patient_entryid']; ?></td>
            <td><?php echo $patient_info['patient_name']; ?></td>
            <td><?php echo $patient_info['patient_age']; ?></td>
            <td><?php echo ($patient_info['patient_gender'] === '0')? 'Male' : 'Female'; ?></td>
            <td><?php echo $patient_info['patient_blood_group']; ?></td>
            <td><?php echo $patient_info['orgcenter_name']; ?></td>
            <td><?php echo $visit_info['visit_visit_center']; ?></td>
            <td><?php echo $visit_info['visit_type']; ?></td>
            <td><?php echo date("d M, Y", strtotime($visit_info['visit_date'])); ?></td>
            <td><?php echo date("d M, Y", strtotime($visit_info['visit_admit_date'])); ?></td>
            <td><?php echo ($visit_info['visit_has_symptomatic'] === '1')? 'Yes' : 'No'; ?></td>
            <td><?php echo $visit_info['visit_symptomatic_type']; ?></td>
            <td><?php echo $visit_info['visit_patient_type']; ?></td>
            <td><?php echo $visit_info['visit_diabetes_duration']; ?></td>
            <td><?php echo $visit_info['visit_types_of_diabetes']; ?></td>
            <td><?php echo $visit_info['visit_guidebook_no']; ?></td>

            <?php foreach($visit_general_examinations as $exam): ?>
              
                <td><strong><?php echo $exam['generalexam_name']; ?> : </strong></td>
                <td><?php echo $exam['generalexam_value']; ?></td>
              
            <?php endforeach; ?>

            <?php foreach($visit_laboratory_investigations as $labinvs): ?>
              
                <td><strong><?php echo $labinvs['labinvs_name']; ?> : </strong></td>
                <td><?php echo $labinvs['labinvs_value']; ?></td>
              
              <?php endforeach; ?>

            <td><strong>ECG : </strong></td>
                <td>
                  <?php 
                    if($visit_laboratory_ecg['ecg_type'] === '0'):
                      $ecg_array1 = array('[', ']', '"');
                      $ecg_array2 = array('', '', '');
                      $labecg_array = str_replace($ecg_array1, $ecg_array2, $visit_laboratory_ecg['ecg_abnormals']);
                      echo 'Abnormal ('.$labecg_array.')';
                    else:
                      echo 'Normal';
                    endif;
                  ?>
                </td>

              <?php  
                $xcount = 1;
                foreach($visit_complications as $complication): 
              ?>
              
                <td><?php echo $xcount; ?></td>
                <td><strong><?php echo $complication['vcomplication_name']; ?> </strong></td>
              
              <?php 
                $xcount++;
                endforeach; 
              ?>

            
              <?php foreach($visit_personal_habits as $habit): ?>
              
                <td><?php echo $habit['phabit_name']; ?></td>
                <td><?php echo $habit['phabit_adiction_type']; ?></td>
                <td><?php echo $habit['phabit_amount']; ?></td>
              
              <?php endforeach; ?>





              <?php 
                    $vls = array('1' => 'Yes', '2' => 'No', '3' => 'Unknown');
                    foreach($family_history as $key):
                  ?>
                  
                    <td><?php echo $key; ?></td>
                    <td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][0]))? $vls[$family_array[$key][0]] : null; ?></td>
                    <td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][1]))? $vls[$family_array[$key][1]] : null; ?></td>
                    <td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][2]))? $vls[$family_array[$key][2]] : null; ?></td>
                    <td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][3]))? $vls[$family_array[$key][3]] : null; ?></td>
                    <td style="padding: 0px;" class="text-center"><?php echo (isset($family_array[$key][4]))? $vls[$family_array[$key][4]] : null; ?></td>
                  
                  <?php 
                    endforeach; 
                  ?>



            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content longer</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
            <td>Cell content</td>
          </tr>
        
           
      
         
        </tbody>
        <tfoot>
         
        </tfoot>
      </table>
    