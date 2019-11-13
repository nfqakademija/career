import React from "react";
import "./Profile.style.scss";
import Comment from "./changeComment.profile.comp";

class Profile extends React.Component {
  constructor() {
    super();

    this.state = {
      showProfile: false
    };
  }

  handle = (profileId, rowID, criteriaID, criteriaName, value) => {
    this.props.change(profileId, rowID, criteriaID, criteriaName, value);
  };

  showProfile = nameOfState => {
    this.setState({ [nameOfState]: !this.state[nameOfState] });
  };

  render() {
    const { id, name, position, all } = this.props;
    return (
      <div>
        <button onClick={() => this.showProfile("showProfile")}>{name}</button>
        {this.state.showProfile ? (
          <div>
            <h5>
              Name: {name} Position: {position}
            </h5>
            <table className="Profile">
              <tbody>
                <tr className="u-textCenter">
                  <th></th>
                  <th>Criteria</th>
                  <th>Self Evaluation</th>
                  <th>Comments</th>
                  <th>Team lead evaluation</th>
                  <th>Overall</th>
                </tr>
                {all.map(data => {
                  return (
                    <React.Fragment key={data.id}>
                      <tr>
                        <td rowSpan={data.list.length}>{data.name}</td>
                        <td>{data.list[0].criteria}</td>

                        <td>
                          <select
                            name="level"
                            defaultValue={data.list[0].selfEvaluation}
                            onChange={value =>
                              this.handle(
                                id,
                                data.id,
                                data.list[0].id,
                                "selfEvaluation",
                                value.target.value
                              )
                            }
                          >
                            <option value="Unfamiliar">Unfamiliar</option>
                            <option value="Familiar">Familiar</option>
                            <option value="Expert">Expert</option>
                          </select>
                        </td>
                        {/* <td onClick={()=>this.showProfile("changeComment")}>
                          {this.state.changeComment?(<input type="text"placeholder={data.list[0].comments}/>):(data.list[0].comments)}
                        </td> */}
                        <Comment id={id} rowId={data.id} criteriaId={data.list[0].id} criteriaName="comments" change={this.handle} name={data.list[0].comments} />
                        <td>
                          <select
                            name="teamLeadEvaluation"
                            defaultValue={
                              data.list[0].teamLeadEvaluation ? "True" : "False"
                            }
                            onChange={value =>
                              this.handle(
                                id,
                                data.id,
                                data.list[0].id,
                                "teamLeadEvaluation",
                                value.target.value
                              )
                            }
                          >
                            <option value="True">True</option>
                            <option value="False">False</option>
                          </select>
                        </td>
                        <td>{data.list[0].overall}</td>
                      </tr>
                      {data.list
                        .filter((check, i) => i !== 0)
                        .map(list => {
                          return (
                            <tr key={list.id}>
                              <td>{list.criteria}</td>

                              <td>
                                <select
                                  name="level"
                                  defaultValue={list.selfEvaluation}
                                  onChange={value =>
                                    this.handle(
                                      id,
                                      data.id,
                                      list.id,
                                      "selfEvaluation",
                                      value.target.value
                                    )
                                  }
                                >
                                  <option value="Unfamiliar">Unfamiliar</option>
                                  <option value="Familiar">Familiar</option>
                                  <option value="Expert">Expert</option>
                                </select>
                              </td>
                              {/* <td>{list.comments}</td> */}
                              <Comment id={id} rowId={data.id} criteriaId={list.id} criteriaName="comments" change={this.handle} name={list.comments} />
                              <td>
                                <select
                                  name="teamLeadEvaluation"
                                  defaultValue={
                                    list.teamLeadEvaluation ? "True" : "False"
                                  }
                                  onChange={value =>
                                    this.handle(
                                      id,
                                      data.id,
                                      list.id,
                                      "teamLeadEvaluation",
                                      value.target.value
                                    )
                                  }
                                >
                                  <option value="True">True</option>
                                  <option value="False">False</option>
                                </select>
                              </td>
                              <td>{list.overall}</td>
                            </tr>
                          );
                        })}
                    </React.Fragment>
                  );
                })}
              </tbody>
            </table>
          </div>
        ) : null}
      </div>
    );
  }
}

export default Profile;

// return [
//   <tr key={data.id}>
//     <td className="u-centerCenter">{data.name}</td>
//     <td>
//       {data.list.map(listCriteria => (
//         <table key={listCriteria.id}>
//           <tbody>
//             <tr>
//               <td className="u-borderNone">
//                 {listCriteria.criteria}
//               </td>
//             </tr>
//           </tbody>
//         </table>
//       ))}
//     </td>
//     <td>
//       {data.list.map(listSelfEvaluation => (
//         <table key={listSelfEvaluation.id}>
//           <tbody>
//             <tr>
//               <td className="u-borderNone">
// <select
//   name="level"
//   defaultValue={listSelfEvaluation.selfEvaluation}
//   onChange={value =>
//     this.handle(
//       id,
//       data.id,
//       listSelfEvaluation.id,
//       "selfEvaluation",
//       value.target.value
//     )
//   }
// >
//   <option value="Unfamiliar">Unfamiliar</option>
//   <option value="Familiar">Familiar</option>
//   <option value="Expert">Expert</option>
// </select>
//               </td>
//             </tr>
//           </tbody>
//         </table>
//       ))}
//     </td>
//     <td>
//       {data.list.map(listComments => (
//         <table key={listComments.id}>
//           <tbody>
//             <tr>
//               <td className="u-borderNone">
//                 {listComments.comments}
//               </td>
//             </tr>
//           </tbody>
//         </table>
//       ))}
//     </td>
//     <td>
//       {data.list.map(listTeamLeadEvaluation => (
//         <table key={listTeamLeadEvaluation.id}>
//           <tbody>
//             <tr>
//               <td className="u-borderNone">
//                 {listTeamLeadEvaluation.teamLeadEvaluation
//                   ? "True"
//                   : "False"}
//               </td>
//             </tr>
//           </tbody>
//         </table>
//       ))}
//     </td>
//     <td>
//       {data.list.map(listOverall => (
//         <table key={listOverall.id}>
//           <tbody>
//             <tr>
//               <td className="u-borderNone">
//                 {listOverall.overall}
//               </td>
//             </tr>
//           </tbody>
//         </table>
//       ))}
//     </td>
//   </tr>
// ];
