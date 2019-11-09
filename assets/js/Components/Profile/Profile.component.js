import React from "react";
import "./Profile.style.scss";

// const Profile = ({ name, position, all }) => {
//   return (
//     <div>
//       <h5>
//         Name: {name} Position: {position}
//       </h5>
//       {all.map((data, index) => {
//         return [
//           <h5 className="criteria" key={index}>
//             {data.name}
//           </h5>,
//           data.list.map(list => {
//             return [
//               <h5 className="criteriaName" key={list.criteria}>
//                 {list.criteria}
//               </h5>,
//               <h5 key={list.selfEvaluation}>{list.selfEvaluation}</h5>,
//               <h5 key={list.comments}>{list.comments}</h5>,
//               <h5 key={list.teamLeadEvaluation}>{list.teamLeadEvaluation}</h5>,
//               <h5 key={list.overall}>{list.overall}</h5>
//             ];
//           })
//         ];
//       })}
//     </div>
//   );
// };

const Profile = ({ name, position, all }) => {
  return (
    <div>
      <h5>
        Name: {name} Position: {position}
      </h5>
      <table className="Profile">
        <tbody>
          <tr className="u-textCenter">
            <td></td>
            <td>Criteria</td>
            <td>Self Evaluation</td>
            <td>Comments</td>
            <td>Team lead evaluation</td>
            <td>Overall</td>
          </tr>
          {all.map(data => {
            return [
              <tr>
                <td className="u-centerCenter">{data.name}</td>
                <td>
                  {data.list.map(list => (
                    <tr>{list.criteria}</tr>
                  ))}
                </td>
                <td>
                  {data.list.map(list => (
                    <tr>{list.selfEvaluation}</tr>
                  ))}
                </td>
                <td>
                  {data.list.map(list => (
                    <tr>{list.comments}</tr>
                  ))}
                </td>
                <td>
                  {data.list.map(list => (
                    <tr>{list.teamLeadEvaluation ? "True" : "False"}</tr>
                  ))}
                </td>
                <td>
                  {data.list.map(list => (
                    <tr>{list.overall}</tr>
                  ))}
                </td>
              </tr>
            ];
          })}
        </tbody>
      </table>
    </div>
  );
};

export default Profile;
