                                @foreach($tickets_completed as $ticket)
                                   <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->email }}</td>
                                    <td>{{ $ticket->issues }}</td>
                                    <td><textarea readonly cols="60" rows="3">{{ $ticket->description }}</textarea></td>
                                    <td>
                                        <select class="form-control form-control-sm status-dropdown"
                                            data-ticket-id="{{ $ticket->id }}">
                                            <option value="Open" {{ $ticket->status=='Open'?'selected':'' }}>Open
                                            </option>
                                            <option value="Hold" {{ $ticket->status=='Hold'?'selected':'' }}>Hold
                                            </option>
                                            <option value="Completed" {{ $ticket->status=='Completed'?'selected':'' }}>
                                                Completed</option>
                                        </select>
                                    </td>

                                    <td>
                                        <textarea id="remarks_{{ $ticket->id }}" class="form-control form-control-sm"
                                            rows="2">{{ $ticket->remark }}</textarea>
                                    </td>



                                </tr>
                                @endforeach