var UnitPopup={popup_template:null,unit_data:{},req_row:'<td><a href="%2">%3</a><br />(Poziom %1)</td>',init:function(){},open:function(event,unit_type){if(mobile){TribalWars.redirect('unit_info',{unit:unit_type});return false};var popup_options={offset_x:-100,offset_y:-100};inlinePopup(event,'unit_popup',null,popup_options,UnitPopup.fetchContent(unit_type));UI.Draggable($('#inline_popup'),{containment:"document"});$('#inline_popup').css("width",'700px').find('h3').hide();$('#inline_popup_main').css("max-height",950);$('#inline_popup_main').css("oveflow-y","scroll");$('#inline_popup_main div').css("height","auto");setTimeout(function(){$('#inline_popup #unit_image').show()},300);return false},showInContainer:function(container,unit_type){container.html(UnitPopup.fetchContent(unit_type))},fetchContent:function(unit_type){var data=this.unit_data[unit_type];this.popup_template=$('#unit_popup_template');$('.dynamic_content',this.popup_template).remove();$.each(data,function(key,value){if(key=='tech_levels')return;UnitPopup.popup_template.find(".unit_"+key).text(value)});$('#inline_popup_title').html(data.name);$('#unit_image',this.popup_template).attr('src',s('/graphic/unit_popup/%1.png',unit_type));if(mobile)$('#unit_image').hide();var speed=Math.round(1/(data.speed*60),2),speed_text=(speed===1)?'1 minuta na pole':s('%1 minut na pole',speed);$('#unit_speed',this.popup_template).text(speed_text);$('.tech_researched, .tech_res_list',this.popup_template).hide();if(data.reqs){$('.show_if_has_reqs',this.popup_template).show();var requirements=$('#reqs',this.popup_template);$.each(data.reqs,function(){var tr=$(s(UnitPopup.req_row,this.level,this.building_link,this.name));tr.addClass('dynamic_content');requirements.append(tr)});$('#reqs_count',this.popup_template).attr('colspan',data.reqs.length)}else $('.show_if_has_reqs',this.popup_template).hide();$('.unit_tech',this.popup_template).hide();if(data.tech_levels){$('.unit_tech_levels',this.popup_template).show();var prototype=$('#unit_tech_prototype',this.popup_template);$.each(data.tech_levels,function(i){var row=prototype.clone();$.each(this,function(key,value){row.find(".tech_"+key).text(value)});if(this.res){$('.tech_wood',row).text(this.res.wood);$('.tech_stone',row).text(this.res.stone);$('.tech_iron',row).text(this.res.iron);$('.tech_res_list',row).show()}else $('.tech_researched',row).show();row.show().attr('id','').addClass("dynamic_content");$('.unit_tech_levels',this.popup_template).append(row)})};if(data.tech_costs){var table=$('.unit_tech_cost',this.popup_template).show();$.each(data.tech_costs,function(res,value){$('.tech_cost_'+res,table).html(value)})};if(data.event_loot)$('.event_loot').show();return this.popup_template.html()}}